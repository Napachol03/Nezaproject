<?php

namespace App\Http\Controllers;

use App\Models\CustomerModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Illuminate\Pagination\Paginator;
use RealRashid\SweetAlert\Facades\Alert;
use Illuminate\Support\Facades\DB;


class CustomerController extends Controller
{
  

    public function __construct()
    {
        // ใช้ middleware 'auth:admin' เพื่อบังคับให้ต้องล็อกอินในฐานะ admin ก่อนใช้งาน controller นี้
        // ถ้าไม่ล็อกอินหรือไม่ได้ใช้ guard 'admin' จะถูก redirect ไปหน้า login
        $this->middleware('auth:admin');
    }

    public function index()
    {
        try {
            Paginator::useBootstrap();
            $customerList = CustomerModel::orderBy('customer_id', 'desc')->paginate(5); //order by & pagination
            return view('customer.list', compact('customerList'));
        } catch (\Exception $e) {
            // \Log::error('Admin list error: '.$e->getMessage());
            return view('errors.404');
        }
    }

    public function adding()
    {
        return view('customer.create');
    }

    public function create(Request $request)
    {
        //vali msg
        $messages = [
            'customer_name.required' => 'กรุณากรอกข้อมูล',
            'customer_name.min' => 'กรอกข้อมูลขั้นต่ำ :min ตัวอักษร',
            'customer_name.unique' => 'ชื่อซ้ำ เพิ่มใหม่อีกครั้ง',
        ];

        //rule
        $validator = Validator::make($request->all(), [
            'customer_name' => 'required|min:3|unique:tbl_nexa_customer',
            'address'       => 'nullable|string',
            'tel'           => 'nullable|string|max:50',
        ], $messages);

        //check vali
        if ($validator->fails()) {
            return redirect('customer/adding')
                ->withErrors($validator)
                ->withInput();
        }

        try {
             //รวม attribute_key[] + attribute_value[] เป็น JSON
            $attributes = [];
            foreach ($request->input('attribute_key', []) as $i => $key) {
                $value = $request->input('attribute_value')[$i] ?? null;
                if (!empty($key) && $value !== null) {
                    $attributes[strip_tags($key)] = strip_tags($value);
                }
            }
            //ปลอดภัย: กัน XSS ที่มาจาก <script>, <img onerror=...> ได้
            $customer = CustomerModel::create([
                'customer_name' => strip_tags($request->input('customer_name')),
                'address'       => strip_tags($request->input('address')),
                'tel'           => strip_tags($request->input('tel')),
            ]);

            
    
            // แสดง Alert ก่อน return
            Alert::success('Insert Successfully');
            return redirect('/customer');
        } catch (\Exception $e) {
            //return response()->json(['error' => $e->getMessage()], 500); //สำหรับ debug
            return view('errors.404');
        }
    } //fun create

    public function edit($id)
    {
        try {
            //query data for form edit
            $customer = CustomerModel::findOrFail($id); // ใช้ findOrFail เพื่อให้เจอหรือ 404
            $id            = $customer->customer_id;
            $customer_name = $customer->customer_name;
            $address       = $customer->address;
            $tel           = $customer->tel;
            return view('customer.edit', compact('id', 'customer_name', 'address', 'tel'));
        } catch (\Exception $e) {
            //return response()->json(['error' => $e->getMessage()], 500); //สำหรับ debug
            return view('errors.404');
        }
    } //func edit

    public function update($id, Request $request)
    {
        //vali msg
        $messages = [
            'customer_name.required' => 'กรุณากรอกข้อมูล',
            'customer_name.min' => 'กรอกข้อมูลขั้นต่ำ :min ตัวอักษร',
            'customer_name.unique' => 'ชื่อนี้ถูกใช้งานแล้ว', //ป้องกันแก้ซ้ำกับ row อื่นๆ จ้าาา
        ];

        //rule
        $validator = Validator::make($request->all(), [
            'customer_name' => [
                'required',
                'min:3',
                Rule::unique('tbl_nexa_customer', 'customer_name')->ignore($id, 'customer_id'), //ห้ามแก้ซ้ำ
            ],
            'address' => 'nullable|string',
            'tel'     => 'nullable|string|max:50',
        ], $messages);

        //check
        if ($validator->fails()) {
            return redirect('customer/' . $id)
                ->withErrors($validator)
                ->withInput();
        }

        try {
            $customer = CustomerModel::findOrFail($id); // กัน error กรณีไม่พบ id
            $customer->update([
                'customer_name' => strip_tags($request->input('customer_name')), //column update
                'address'       => strip_tags($request->input('address')),
                'tel'           => strip_tags($request->input('tel')),
            ]);
            // แสดง Alert ก่อน return
            Alert::success('Update Successfully');
            return redirect('/customer');
        } catch (\Exception $e) {
            //return response()->json(['error' => $e->getMessage()], 500); //สำหรับ debug
            return view('errors.404');
        }
    } //fun update

    public function remove($id)
    {
        try {
            $customer = CustomerModel::findOrFail($id); //query หาว่ามีไอดีนี้อยู่จริงไหม
            $customer->delete();
            Alert::success('Delete Successfully');
            return redirect('/customer');
        } catch (\Exception $e) {
            //return response()->json(['error' => $e->getMessage()], 500); //สำหรับ debug
            return view('errors.404');
        }
    } //remove

    /**
     * POST /customer
     * บันทึกลูกค้า/หน่วยงานใหม่จาก Modal ในฟอร์มใบเสนอราคา
     * ใช้ validateWithBag('customer', ...) เพื่อให้ error โชว์เฉพาะใน Modal นี้
     * (ไม่ปนกับ error ของฟอร์มใบเสนอราคาหลัก) แบบเดียวกับ Modal เพิ่มหมวดหมู่สินค้า
     */
    public function store(Request $request)
    {
        $validated = $request->validateWithBag('customer', [
            'customer_name' => 'required|string|min:2|max:255',
            'address'       => 'nullable|string',
            'tel'           => 'nullable|string|max:50',
        ]);

        $customer = CustomerModel::create($validated);

        // เก็บ id ลูกค้าที่เพิ่งสร้างไว้ใน session เพื่อให้ select ในฟอร์มใบเสนอราคา
        // เลือกลูกค้ารายนี้ให้อัตโนมัติทันทีที่ redirect กลับไป (ตรงกับ session('new_customer_id') ในฟอร์ม)
        session(['new_customer_id' => $customer->customer_id]);

        return back()->with('success', 'เพิ่มลูกค้า/หน่วยงานเรียบร้อยแล้ว');
    }
}