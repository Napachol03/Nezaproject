<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;
use RealRashid\SweetAlert\Facades\Alert;
use App\Models\ProductModel;
use App\Models\CategoryModel;
use App\Models\ProductImageModel;
use Illuminate\Pagination\Paginator;

class ProductController extends Controller
{
   
    public function __construct()
    {
        // ใช้ middleware 'auth:admin' เพื่อบังคับให้ต้องล็อกอินในฐานะ admin ก่อนใช้งาน controller นี้
        // ถ้าไม่ล็อกอินหรือไม่ได้ใช้ guard 'admin' จะถูก redirect ไปหน้า login
        $this->middleware('auth:admin');
    }


    public function index(Request $request)
    {
        try {
            Paginator::useBootstrap();

            $query = ProductModel::with(['category', 'images'])
                ->orderBy('product_id', 'desc');
            if ($request->filled('category_id')) {
                $query->where('category_id', $request->input('category_id'));
            }
            $productList = $query->paginate(15)->withQueryString(); // ต่อท้าย query string ไปกับ pagination ด้วย
            $categories = CategoryModel::orderBy('category_name')->get();

            return view('product.list', compact('productList', 'categories'));
        } catch (\Exception $e) {
            Log::error('[ProductController@index] ' . $e->getMessage(), [
                'file' => $e->getFile(),
                'line' => $e->getLine(),
            ]);
            return view('errors.404');
        }
    }

    public function adding()
    {
        $categories = CategoryModel::orderBy('category_name')->get();
        // ดึง attribute keys/values ที่เคยใช้แล้วทั้งหมด จากทุกสินค้า
        $allAttributes = ProductModel::whereNotNull('attributes')->pluck('attributes');

        $usedKeys = [];
        $usedValues = [];
        foreach ($allAttributes as $attrs) {
            foreach ($attrs as $key => $value) {
                $usedKeys[$key] = true;
                $usedValues[$value] = true;
            }
        }

        $usedKeys = array_keys($usedKeys);
        $usedValues = array_keys($usedValues);

        return view('product.create', compact('categories', 'usedKeys', 'usedValues'));
    }

    public function create(Request $request)
    {
        //vali msg
        $messages = [
            'product_name.required' => 'กรุณากรอกข้อมูล',
            'product_name.min'      => 'กรอกข้อมูลขั้นต่ำ :min ตัวอักษร',
            'category_id.required'  => 'กรุณาเลือกหมวดหมู่',
            'description.required'  => 'กรุณารายละเอียดของข้อมูล',
            'images.'  => 'กรุณารายละเอียดของข้อมูล'
        ];

        //rule
        $validator = Validator::make($request->all(), [
            'product_name'       => 'required|min:3',
            'description'        => 'required|string',
            'category_id'        => 'required|exists:tbl_nexa_category,category_id',
            'is_featured'        => 'nullable|boolean',
            'is_active'          => 'nullable|boolean',
            'attribute_key'      => 'array',
            'attribute_key.*'    => 'nullable|string|max:100',
            'attribute_value'    => 'array',
            'attribute_value.*'  => 'nullable|string|max:255',
            'images'             => 'nullable|array',
            'images.*'           => 'image|max:4096',
        ], $messages);

        //check vali
        if ($validator->fails()) {
            // AJAX/fetch request -> ตอบกลับเป็น JSON แทนการ redirect เต็มหน้า
            // (สำคัญ: การ redirect เต็มหน้าจะทำให้ input type="file" และ JS state
            // ของรูปภาพที่ผู้ใช้จัดการไว้ในโมดัลหายไปทั้งหมด)
            if ($request->wantsJson() || $request->ajax()) {
                return response()->json([
                    'success' => false,
                    'errors'  => $validator->errors(),
                ], 422);
            }

            return redirect('product/adding')
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
            $product = ProductModel::create([
                'product_name' => strip_tags($request->input('product_name')),
                'description'  => strip_tags($request->input('description')),
                'category_id'  => $request->input('category_id'),
                'attributes'   => $attributes,
                'is_featured'  => $request->boolean('is_featured'),
                'is_active'    => $request->boolean('is_active', true),
            ]);

            if ($request->hasFile('images')) {
                foreach ($request->file('images') as $index => $file) {
                    $path = $file->store('products', 'public');
                    ProductImageModel::create([
                        'product_id' => $product->product_id,
                        'image_url'  => Storage::url($path),
                        'is_primary' => $index === 0,
                        'sort_order' => $index,
                    ]);
                }
            }

            // AJAX/fetch request -> ตอบกลับ JSON พร้อม url ให้ JS สั่ง redirect เอง
            if ($request->wantsJson() || $request->ajax()) {
                return response()->json([
                    'success'  => true,
                    'redirect' => '/product',
                ]);
            }

            // แสดง Alert ก่อน return
            Alert::success('Insert Successfully');
            return redirect('/product');
        } catch (\Exception $e) {
            Log::error('[ProductController@create] ' . $e->getMessage(), [
                'file' => $e->getFile(),
                'line' => $e->getLine(),
            ]);

            if ($request->wantsJson() || $request->ajax()) {
                return response()->json([
                    'success' => false,
                    'message' => 'เกิดข้อผิดพลาดในการบันทึกข้อมูล',
                ], 500);
            }

            //return response()->json(['error' => $e->getMessage()], 500); //สำหรับ debug
            return view('errors.404');
        }
    } //fun create

    public function edit($id)
    {
        
        try {
            //query data for form edit
            $product = ProductModel::with('images')->findOrFail($id); // ใช้ findOrFail เพื่อให้เจอหรือ 404
            $categories = CategoryModel::orderBy('category_name')->get();

            // ดึง attribute keys/values ที่เคยใช้แล้วทั้งหมด จากทุกสินค้า (เหมือนหน้า adding)
            $allAttributes = ProductModel::whereNotNull('attributes')->pluck('attributes');

            $usedKeys = [];
            $usedValues = [];
            foreach ($allAttributes as $attrs) {
                foreach ($attrs as $key => $value) {
                    $usedKeys[$key] = true;
                    $usedValues[$value] = true;
                }
            }

            $usedKeys = array_keys($usedKeys);
            $usedValues = array_keys($usedValues);

            if (isset($product)) {
                return view('product.edit', compact('product', 'categories', 'usedKeys', 'usedValues'));
            }
        } catch (\Exception $e) {
            Log::error('[ProductController@edit] ' . $e->getMessage(), [
                'file' => $e->getFile(),
                'line' => $e->getLine(),
            ]);
            //return response()->json(['error' => $e->getMessage()], 500); //สำหรับ debug
            return view('errors.404');
        }
    } //func edit


    public function update($id, Request $request)
    {
        //vali msg
        $messages = [
            'product_name.required' => 'กรุณากรอกข้อมูล',
            'product_name.min'      => 'กรอกข้อมูลขั้นต่ำ :min ตัวอักษร',
            'category_id.required'  => 'กรุณาเลือกหมวดหมู่',
            'description.required'  => 'กรุณารายละเอียดของข้อมูล',
        ];

        // หมายเหตุ: image_order[] ที่ส่งมาจากฟอร์ม edit.blade.php เป็น
        // key => value = image_id => ตัวเลขลำดับ (sort_order) เช่น
        // image_order[12] = "3", image_order[15] = "1"
        // จึงต้อง validate ค่าเป็น integer ธรรมดา ไม่ใช่ string แบบ "existing_12"/"new_0"
        $validator = Validator::make($request->all(), [
            'product_name'       => 'required|min:3',
            'description'        => 'required|string',
            'category_id'        => 'required|exists:tbl_nexa_category,category_id',
            'is_featured'        => 'nullable|boolean',
            'is_active'          => 'nullable|boolean',
            'attribute_key'      => 'array',
            'attribute_key.*'    => 'nullable|string|max:100',
            'attribute_value'    => 'array',
            'attribute_value.*'  => 'nullable|string|max:255',
            'images'             => 'nullable|array',
            'images.*'           => 'image|max:4096',
            'image_order'        => 'nullable|array',
            'image_order.*'      => 'nullable|integer|min:0',
            'primary_image_id'   => 'nullable|integer|exists:tbl_nexa_product_image,image_id',
            'delete_images'      => 'nullable|array',
            'delete_images.*'    => 'integer|exists:tbl_nexa_product_image,image_id',
        ], $messages);

        //check
        if ($validator->fails()) {
            // Debug: log ว่ารอบนี้ตกเพราะ field ไหน จะได้เห็นชัดว่าทำไม
            // form submit แล้วไม่ไปหน้า list (คือ validate ไม่ผ่าน redirect กลับหน้าเดิม)
            Log::error('[ProductController@update] validation failed', [
                'product_id' => $id,
                'errors'     => $validator->errors()->toArray(),
            ]);

            return redirect('product/' . $id)
                ->withErrors($validator)
                ->withInput();
        }

        try {
            $product = ProductModel::findOrFail($id);

            $attributes = [];
            foreach ($request->input('attribute_key', []) as $i => $key) {
                $value = $request->input('attribute_value')[$i] ?? null;
                if (!empty($key) && $value !== null) {
                    $attributes[strip_tags($key)] = strip_tags($value);
                }
            }

            $product->update([
                'product_name' => strip_tags($request->input('product_name')),
                'description'  => strip_tags($request->input('description')),
                'category_id'  => $request->input('category_id'),
                'attributes'   => $attributes,
                'is_featured'  => $request->boolean('is_featured'),
                'is_active'    => $request->boolean('is_active'),
            ]);

            // 1) ลบรูปที่เลือกลบ
            $deleteIds = $request->input('delete_images', []);
            if (!empty($deleteIds)) {
                $imagesToDelete = ProductImageModel::whereIn('image_id', $deleteIds)
                    ->where('product_id', $product->product_id)
                    ->get();

                foreach ($imagesToDelete as $img) {
                    $path = str_replace('/storage/', '', $img->image_url);
                    Storage::disk('public')->delete($path);
                    $img->delete();
                }
            }

            // 2) อัปเดตลำดับของรูปเดิมที่เหลืออยู่ (image_order[image_id] = sort_order)
            $imageOrder = $request->input('image_order', []);
            foreach ($imageOrder as $imageId => $order) {
                ProductImageModel::where('image_id', $imageId)
                    ->where('product_id', $product->product_id)
                    ->update(['sort_order' => (int) $order]);
            }

            // 3) เพิ่มรูปใหม่ที่อัปโหลดเข้ามา ต่อท้ายลำดับปัจจุบัน
            if ($request->hasFile('images')) {
                $maxOrder = $product->images()->max('sort_order') ?? -1;
                foreach ($request->file('images') as $index => $file) {
                    $path = $file->store('products', 'public');
                    ProductImageModel::create([
                        'product_id' => $product->product_id,
                        'image_url'  => Storage::url($path),
                        'is_primary' => false,
                        'sort_order' => $maxOrder + $index + 1,
                    ]);
                }
            }

            // 4) ตั้งรูปหลักจากที่ผู้ใช้เลือก (radio primary_image_id อ้างอิง image_id ของรูปเดิม)
            $primaryId = $request->input('primary_image_id');
            if ($primaryId) {
                $product->images()->update(['is_primary' => false]);
                ProductImageModel::where('image_id', $primaryId)
                    ->where('product_id', $product->product_id)
                    ->update(['is_primary' => true]);
            }

            // กันเหนียว: ถ้าไม่มีรูปไหนเป็น primary เลย ให้ตั้งรูปแรกสุด (sort_order น้อยสุด) เป็น primary
            if (!$product->images()->where('is_primary', true)->exists()) {
                $firstImage = $product->images()->orderBy('sort_order')->first();
                if ($firstImage) {
                    $firstImage->update(['is_primary' => true]);
                }
            }

            Alert::success('Update Successfully');
            return redirect('/product');
        } catch (\Exception $e) {
            // Debug: log exception จริงลง storage/logs/laravel.log
            // เดิม catch นี้ "กลืน" error เงียบๆ แล้วโชว์ errors.404 อย่างเดียว
            // ทำให้ไม่รู้เลยว่าทำไมกด "บันทึกข้อมูล" แล้วไม่ redirect ไปหน้า list
            Log::error('[ProductController@update] ' . $e->getMessage(), [
                'product_id' => $id,
                'file'       => $e->getFile(),
                'line'       => $e->getLine(),
                'trace'      => $e->getTraceAsString(),
            ]);

            //return response()->json(['error' => $e->getMessage(), 'line' => $e->getLine()], 500); //สำหรับ debug ชั่วคราว
            return view('errors.404');
        }
    } //fun update


    public function remove($id)
    {
        try {
            $product = ProductModel::findOrFail($id);

            // ลบ quotation detail ที่อ้างอิงสินค้านี้ก่อน (ป้องกัน foreign key constraint fails)
            // เพราะ product_id ถูกอ้างอิงอยู่ใน tbl_nexa_quotation_detail
            $product->quotationDetails()->delete();

            foreach ($product->images as $image) {
                $path = str_replace('/storage/', '', $image->image_url);
                Storage::disk('public')->delete($path);
            }
            $product->delete();

            Alert::success('Delete Successfully');
            return redirect('/product');
        } catch (\Exception $e) {
            //return response()->json(['error' => $e->getMessage()], 500); //สำหรับ debug
            return view('errors.404');
        }
    } //remove

} //class