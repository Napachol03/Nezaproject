<?php

namespace App\Http\Controllers;

use App\Models\QuotationModel;
use App\Models\QuotationDetailModel;
use RealRashid\SweetAlert\Facades\Alert;
use App\Models\CustomerModel;
use App\Models\ProductModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class QuotationController extends Controller
{
   
    public function __construct()
    {
        // ใช้ middleware 'auth:admin' เพื่อบังคับให้ต้องล็อกอินในฐานะ admin ก่อนใช้งาน controller นี้
        // ถ้าไม่ล็อกอินหรือไม่ได้ใช้ guard 'admin' จะถูก redirect ไปหน้า login
        $this->middleware('auth:admin');
    }

    /**
     * GET /quotation
     * แสดงรายการใบเสนอราคาทั้งหมด (ค้นหา/กรองสถานะได้)
     */
    public function index(Request $request)
    {
        $query = QuotationModel::with('customer');

        if ($request->filled('keyword')) {
            $keyword = $request->input('keyword');
            $query->where('quotation_no', 'like', "%{$keyword}%")
                ->orWhereHas('customer', function ($q) use ($keyword) {
                    $q->where('customer_name', 'like', "%{$keyword}%");
                });
        }

        if ($request->filled('status')) {
            $query->where('status', $request->input('status'));
        }

        $quotations = $query->orderByDesc('quotation_id')->paginate(20);

        return view('quotation.list', compact('quotations'));
    }

    /**
     * GET /quotation/adding
     * แสดงฟอร์มสร้างใบเสนอราคาใหม่
     */
    public function adding()
    {
        $customers = CustomerModel::orderBy('customer_name')->get();
        $products  = ProductModel::orderBy('product_name')->get();
        $nextNo    = $this->buildNextQuotationNo();

        return view('quotation.adding', compact('customers', 'products', 'nextNo'));
    }

    /**
     * POST /quotation
     * บันทึกใบเสนอราคาใหม่ พร้อมรายการสินค้า (ทำใน transaction เดียว)
     */
    public function create(Request $request)
    {
        $validated = $this->validateQuotation($request);

        DB::beginTransaction();
        try {
            [$runningNo, $yearBe, $quotationNo] = $this->resolveQuotationNo($request->input('quotation_no'));

            $items = $validated['items'];
            $subtotal = collect($items)->sum(function ($item) {
                return $item['quantity'] * $item['unit_price'];
            });
            $vatRate   = $validated['vat_rate'] ?? 7.00;
            $vatAmount = round($subtotal * ($vatRate / 100), 2);
            $total     = $subtotal + $vatAmount;

            $quotation = QuotationModel::create([
                'quotation_no'         => $quotationNo,
                'running_no'           => $runningNo,
                'quotation_year_be'    => $yearBe,
                'quotation_date'       => $validated['quotation_date'] ?? null,
                'customer_id'          => $validated['customer_id'],
                'admin_id'             => auth()->id(),
                'subject'              => $validated['subject'] ?? 'ขอเสนอราคาสินค้าดังรายการต่อไปนี้',
                'subtotal_amount'      => $subtotal,
                'vat_rate'             => $vatRate,
                'vat_amount'           => $vatAmount,
                'total_amount'         => $total,
                'price_validity_days'  => $validated['price_validity_days'] ?? 30,
                'payment_terms'        => $validated['payment_terms'] ?? 'ตามหลักเกณฑ์ของทางราชการ',
                'status'               => 'draft',
            ]);

            foreach ($items as $index => $item) {
                QuotationDetailModel::create([
                    'quotation_id' => $quotation->quotation_id,
                    'product_id'   => $item['product_id'],
                    'item_order'   => $index + 1,
                    'description'  => $item['description'] ?? null,
                    'quantity'     => $item['quantity'],
                    'unit'         => $item['unit'],
                    'unit_price'   => $item['unit_price'],
                ]);
            }

            DB::commit();
        } catch (\Throwable $e) {
            DB::rollBack();
            Alert::error('เกิดข้อผิดพลาด', 'บันทึกใบเสนอราคาไม่สำเร็จ: ' . $e->getMessage());
            return back()->withInput()->withErrors(['error' => 'บันทึกใบเสนอราคาไม่สำเร็จ: ' . $e->getMessage()]);
        }

        Alert::success('สำเร็จ', "สร้างใบเสนอราคาเลขที่ {$quotation->quotation_no} เรียบร้อยแล้ว");
        return redirect('/quotation')
            ->with('success', "สร้างใบเสนอราคาเลขที่ {$quotation->quotation_no} เรียบร้อยแล้ว");
    }

    /**
     * GET /quotation/{id}/print
     * หน้าพิมพ์ใบเสนอราคา (แสดงรายการสินค้าครบตามเอกสารต้นฉบับ)
     */
    public function printView($id)
    {
        $quotation = QuotationModel::with(['customer', 'admin', 'details.product'])
            ->findOrFail($id);

        return view('quotation.print', compact('quotation'));
    }

    /**
     * GET /quotation/{id}
     * แสดงฟอร์มแก้ไขใบเสนอราคา (โหลดหัวเอกสาร + รายการสินค้าเดิม)
     */
    public function edit($id)
    {
        $quotation = QuotationModel::with(['customer', 'admin', 'details.product'])
            ->findOrFail($id);
        $customers = CustomerModel::orderBy('customer_name')->get();
        $products  = ProductModel::orderBy('product_name')->get();

        return view('quotation.edit', compact('quotation', 'customers', 'products'));
    }

    /**
     * PUT /quotation/{id}
     * แก้ไขใบเสนอราคา (ลบรายการสินค้าเดิมแล้วบันทึกรายการใหม่ทับ)
     */
    public function update(Request $request, $id)
    {
        $quotation = QuotationModel::findOrFail($id);
        $validated = $this->validateQuotation($request);

        $statusValidated = $request->validate([
            'status' => 'nullable|in:draft,sent,approved,rejected',
        ]);

        DB::beginTransaction();
        try {
            $items = $validated['items'];
            $subtotal = collect($items)->sum(function ($item) {
                return $item['quantity'] * $item['unit_price'];
            });
            $vatRate   = $validated['vat_rate'] ?? $quotation->vat_rate;
            $vatAmount = round($subtotal * ($vatRate / 100), 2);
            $total     = $subtotal + $vatAmount;

            $quotation->update([
                'quotation_date'      => $validated['quotation_date'] ?? $quotation->quotation_date,
                'customer_id'         => $validated['customer_id'],
                'subject'             => $validated['subject'] ?? $quotation->subject,
                'subtotal_amount'     => $subtotal,
                'vat_rate'            => $vatRate,
                'vat_amount'          => $vatAmount,
                'total_amount'        => $total,
                'price_validity_days' => $validated['price_validity_days'] ?? $quotation->price_validity_days,
                'payment_terms'       => $validated['payment_terms'] ?? $quotation->payment_terms,
                'status'              => $statusValidated['status'] ?? $quotation->status,
            ]);

            QuotationDetailModel::where('quotation_id', $quotation->quotation_id)->delete();

            foreach ($items as $index => $item) {
                QuotationDetailModel::create([
                    'quotation_id' => $quotation->quotation_id,
                    'product_id'   => $item['product_id'],
                    'item_order'   => $index + 1,
                    'description'  => $item['description'] ?? null,
                    'quantity'     => $item['quantity'],
                    'unit'         => $item['unit'],
                    'unit_price'   => $item['unit_price'],
                ]);
            }

            DB::commit();
        } catch (\Throwable $e) {
            DB::rollBack();
            Alert::error('เกิดข้อผิดพลาด', 'แก้ไขใบเสนอราคาไม่สำเร็จ: ' . $e->getMessage());
            return back()->withInput()->withErrors(['error' => 'แก้ไขใบเสนอราคาไม่สำเร็จ: ' . $e->getMessage()]);
        }

        Alert::success('แก้ไขสำเร็จ', "แก้ไขใบเสนอราคาเลขที่ {$quotation->quotation_no} เรียบร้อยแล้ว");
        return redirect('/quotation')
            ->with('success', "แก้ไขใบเสนอราคาเลขที่ {$quotation->quotation_no} เรียบร้อยแล้ว");
    }

    /**
     * DELETE /quotation/remove/{id}
     * ลบใบเสนอราคา (รายการสินค้าจะถูกลบตามด้วย ON DELETE CASCADE)
     */
    public function remove($id)
{
    try {
        $quotation = QuotationModel::find($id); //query หาว่ามีไอดีนี้อยู่จริงไหม
        $quotationNo = $quotation->quotation_no;
        $quotation->delete();
        Alert::success('สำเร็จ', "ลบใบเสนอราคาเลขที่ {$quotationNo} เรียบร้อยแล้ว");
        return redirect('/quotation');
    } catch (\Throwable $e) {
        //return response()->json(['error' => $e->getMessage()], 500); //สำหรับ debug
        return view('errors.404');
    }
}

    // -------------------------------------------------------------------
    // Helper methods
    // -------------------------------------------------------------------

    /**
     * ตรวจสอบข้อมูลที่ส่งมาจากฟอร์ม (หัวใบเสนอราคา + รายการสินค้า)
     * ก่อนตรวจสอบ จะกรองแถวรายการสินค้าที่ "ว่างเปล่าล้วนๆ" ออกก่อนเสมอ
     * (เช่น แถวต้นแบบที่ผู้ใช้ไม่ได้กรอกอะไรเลย หรือแถวที่ clone มาแล้วไม่ได้ลบทิ้ง)
     * เพื่อไม่ให้มีรายการสินค้าว่างหลุดเข้าไปบันทึกในฐานข้อมูล
     */
    private function validateQuotation(Request $request): array
    {
        $rawItems = $request->input('items', []);

        $cleanedItems = array_values(array_filter($rawItems, function ($item) {
            // เก็บแถวไว้ก็ต่อเมื่อมีการกรอกอย่างน้อย 1 ช่องที่มีความหมาย
            // (เลือกสินค้า หรือกรอกจำนวน/หน่วย/ราคา อย่างใดอย่างหนึ่ง)
            return !empty($item['product_id'])
                || !empty($item['quantity'])
                || !empty($item['unit'])
                || !empty($item['unit_price']);
        }));

        $request->merge(['items' => $cleanedItems]);

        $validator = Validator::make($request->all(), [
            'customer_id'                => 'required|integer|exists:tbl_nexa_customer,customer_id',
            'quotation_date'             => 'nullable|date',
            'subject'                    => 'nullable|string|max:255',
            'vat_rate'                   => 'nullable|numeric|min:0|max:100',
            'price_validity_days'        => 'nullable|integer|min:0',
            'payment_terms'              => 'nullable|string|max:255',
            'quotation_no'               => 'nullable|string|max:20',
            'items'                      => 'required|array|min:1',
            'items.*.product_id'         => 'required|integer|exists:tbl_nexa_product,product_id',
            'items.*.description'        => 'nullable|string',
            'items.*.quantity'           => 'required|numeric|min:0.01',
            'items.*.unit'               => 'required|string|max:30',
            'items.*.unit_price'         => 'required|numeric|min:0',
        ], [
            'customer_id.required' => 'กรุณาเลือกลูกค้า/หน่วยงาน',
            'items.required'       => 'กรุณาเพิ่มรายการสินค้าอย่างน้อย 1 รายการ',
        ]);

        return $validator->validate();
    }

    /**
     * แปลงเลขที่ใบเสนอราคาที่ผู้ใช้กรอก (หรือคำนวณอัตโนมัติ) เป็น [running_no, year_be, quotation_no]
     */
    private function resolveQuotationNo(?string $inputNo): array
    {
        $yearBe = (int) date('Y') + 543;

        if ($inputNo && preg_match('/^(\d+)\/(\d{4})$/', $inputNo, $m)) {
            return [(int) $m[1], (int) $m[2], $inputNo];
        }

        $runningNo = (QuotationModel::where('quotation_year_be', $yearBe)->max('running_no') ?? 0) + 1;
        $quotationNo = sprintf('%03d/%d', $runningNo, $yearBe);

        return [$runningNo, $yearBe, $quotationNo];
    }

    /**
     * สร้างเลขที่ใบเสนอราคาถัดไป สำหรับแสดงในฟอร์ม "สร้างใหม่" (preview เท่านั้น)
     */
    private function buildNextQuotationNo(): string
    {
        [,, $quotationNo] = $this->resolveQuotationNo(null);
        return $quotationNo;
    }
}
