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
        $this->middleware('auth:admin');
    }

    public function create(Request $request)
    {
        $messages = [
            'category_name.required' => 'กรุณากรอกชื่อหมวดหมู่',
            'category_name.min'      => 'กรอกข้อมูลขั้นต่ำ :min ตัวอักษร',
            'category_name.unique'   => 'ชื่อหมวดหมู่นี้มีอยู่แล้ว กรุณาใช้ชื่ออื่น',
        ];

        $validator = Validator::make($request->all(), [
            'category_name' => 'required|min:2|unique:tbl_nexa_category,category_name',
            'parent_id'      => 'nullable|exists:tbl_nexa_category,category_id',
        ], $messages);

        if ($validator->fails()) {
            // AJAX request -> ตอบกลับเป็น JSON แทนการ redirect/reload หน้า
            if ($request->ajax() || $request->wantsJson()) {
                return response()->json([
                    'success' => false,
                    'errors'  => $validator->errors(),
                ], 422);
            }

            return redirect()->back()
                ->withErrors($validator, 'category')
                ->withInput();
        }

        try {
            $category = CategoryModel::create([
                'category_name' => strip_tags($request->input('category_name')),
                'parent_id'     => $request->input('parent_id') ?: null,
            ]);

            if ($request->ajax() || $request->wantsJson()) {
                return response()->json([
                    'success' => true,
                    'category' => [
                        'category_id'   => $category->category_id,
                        'category_name' => $category->category_name,
                    ],
                ]);
            }

            Alert::success('Insert Successfully', 'เพิ่มหมวดหมู่เรียบร้อยแล้ว');
            return redirect()->back()->with('new_category_id', $category->category_id);
        } catch (\Exception $e) {
            if ($request->ajax() || $request->wantsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => 'เกิดข้อผิดพลาดในการบันทึกหมวดหมู่ กรุณาลองใหม่อีกครั้ง',
                ], 500);
            }
            return view('errors.404');
        }
    }
}