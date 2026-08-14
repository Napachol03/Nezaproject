<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use RealRashid\SweetAlert\Facades\Alert;
use App\Models\CategoryModel;

class CategoryController extends Controller
{
  

    public function __construct()
    {
        // ใช้ middleware 'auth:admin' เพื่อบังคับให้ต้องล็อกอินในฐานะ admin ก่อนใช้งาน controller นี้
        // ถ้าไม่ล็อกอินหรือไม่ได้ใช้ guard 'admin' จะถูก redirect ไปหน้า login
        $this->middleware('auth:admin');
    }

    public function create(Request $request)
    {
        $messages = [
            'category_name.required' => 'กรุณากรอกชื่อหมวดหมู่',
            'category_name.min'      => 'กรอกข้อมูลขั้นต่ำ :min ตัวอักษร',
        ];

        $validator = Validator::make($request->all(), [
            'category_name' => 'required|min:2',
            'parent_id'      => 'nullable|exists:tbl_nexa_category,category_id',
        ], $messages);

        if ($validator->fails()) {
            return redirect('product/adding')
                ->withErrors($validator, 'category') // แยก error bag กันชนกับฟอร์มสินค้า
                ->withInput();
        }

        try {
            CategoryModel::create([
                'category_name' => strip_tags($request->input('category_name')),
                'parent_id'     => $request->input('parent_id') ?: null,
            ]);

            Alert::success('Insert Successfully', 'เพิ่มหมวดหมู่เรียบร้อยแล้ว');
            return redirect('product/adding');
        } catch (\Exception $e) {
            return view('errors.404');
        }
    }
}