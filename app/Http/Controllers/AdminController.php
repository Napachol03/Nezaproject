<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use RealRashid\SweetAlert\Facades\Alert;
use Illuminate\Support\Facades\Storage;
use Illuminate\Pagination\Paginator;
use Illuminate\Validation\Rule;
use App\Models\AdminModel;


class AdminController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:admin');
    }

    public function index()
    {
        try {
            Paginator::useBootstrap();
            $AdminList = AdminModel::orderBy('id', 'desc')->paginate(5);
            return view('admin.list', compact('AdminList'));
        } catch (\Exception $e) {
            return view('errors.404');
        }
    }

    public function adding()
    {
        return view('admin.create');
    }

    public function create(Request $request)
    {
        $messages = [
            'full_name.required'      => 'กรุณากรอกข้อมูล',
            'full_name.min'           => 'กรอกข้อมูลขั้นต่ำ :min ตัวอักษร',
            'username.required'       => 'กรุณากรอกข้อมูล',
            'username.min'            => 'กรอกข้อมูลขั้นต่ำ :min ตัวอักษร',
            'username.unique'         => 'ชื่อผู้ใช้นี้ถูกใช้แล้ว',
            'password.required'       => 'กรุณากรอกข้อมูล',
            'password.min'            => 'กรอกข้อมูลขั้นต่ำ :min ตัวอักษร',
            'email.required'          => 'กรุณากรอกข้อมูล',
            'email.email'             => 'รูปแบบอีเมลไม่ถูกต้อง',
            'email.unique'            => 'Email ซ้ำ',
            'phone.required'          => 'กรุณากรอกข้อมูล',
            'phone.min'               => 'กรอกข้อมูลขั้นต่ำ :min ตัวอักษร',
            'phone.unique'            => 'เบอร์นี้ถูกใช้แล้ว',
            'role.required'           => 'กรุณาเลือกสิทธิ์การใช้งาน',
            'avatar_url.mimes'        => 'รองรับเฉพาะ jpeg, png, jpg !!',
            'avatar_url.max'          => 'ขนาดไฟล์ไม่เกิน 5MB !!',
        ];

        $validator = Validator::make($request->all(), [
            'full_name'  => 'required|min:3',
            'username'   => 'required|min:3|unique:tbl_nexa_admin',
            'email'      => 'required|email|unique:tbl_nexa_admin',
            'password'   => 'required|min:8',
            'phone'      => 'required|min:10|unique:tbl_nexa_admin',
            'role'       => 'required|in:super_admin,admin,staff',
            'avatar_url' => 'nullable|image|mimes:jpeg,png,jpg|max:5120',
        ], $messages);

        if ($validator->fails()) {
            return redirect('admin/adding')
                ->withErrors($validator)
                ->withInput();
        }

        try {
            $imagePath = null;
            if ($request->hasFile('avatar_url')) {
                $imagePath = $request->file('avatar_url')->store('uploads/admin', 'public');
            }

            AdminModel::create([
                'full_name'        => strip_tags($request->full_name),
                'username'         => strip_tags($request->username),
                'password_hash' => bcrypt($request->password),
                'phone'            => strip_tags($request->phone),
                'email'            => strip_tags($request->email),
                'role'             => strip_tags($request->role),
                'status'           => 'active',
                'avatar_url'       => $imagePath,
                'is_login_allowed' => $request->has('is_login_allowed'),
            ]);

            Alert::success('เพิ่มข้อมูลเรียบร้อยแล้ว');
            return redirect('/admin');
        } catch (\Exception $e) {
            return view('errors.404');
        }
    }

    public function edit($id)
    {
        try {
            $admin = AdminModel::findOrFail($id);
            if (isset($admin)) {
                $id               = $admin->id;
                $full_name        = $admin->full_name;
                $username         = $admin->username;
                $phone            = $admin->phone;
                $email            = $admin->email;
                $role             = $admin->role;
                $status           = $admin->status;
                $avatar_url       = $admin->avatar_url;
                $is_login_allowed = $admin->is_login_allowed;

                return view('admin.edit', compact(
                    'id', 'full_name', 'username', 'phone', 'email',
                    'role', 'status', 'avatar_url', 'is_login_allowed'
                ));
            }
        } catch (\Exception $e) {
            return view('errors.404');
        }
    }

    public function update($id, Request $request)
    {
        $messages = [
            'full_name.required'  => 'กรุณากรอกชื่อ',
            'full_name.min'       => 'กรอกข้อมูลขั้นต่ำ :min ตัวอักษร',
            'username.required'   => 'กรุณากรอกชื่อผู้ใช้',
            'username.min'        => 'กรอกข้อมูลขั้นต่ำ :min ตัวอักษร',
            'username.unique'     => 'ชื่อผู้ใช้นี้ถูกใช้แล้ว',
            'email.required'      => 'กรุณากรอกอีเมล',
            'email.email'         => 'รูปแบบอีเมลไม่ถูกต้อง',
            'email.unique'        => 'Email ซ้ำ',
            'phone.required'      => 'กรุณากรอกเบอร์โทรศัพท์',
            'phone.min'           => 'กรอกข้อมูลขั้นต่ำ :min ตัวอักษร',
            'phone.unique'        => 'เบอร์นี้ถูกใช้แล้ว',
            'role.required'       => 'กรุณาเลือกสิทธิ์การใช้งาน',
            'avatar_url.mimes'    => 'รองรับ jpeg, png, jpg เท่านั้น !!',
            'avatar_url.max'      => 'ขนาดไฟล์ไม่เกิน 5MB !!',
        ];

        $validator = Validator::make($request->all(), [
            'full_name' => 'required|min:3',
            'username' => [
                'required', 'min:3',
                Rule::unique('tbl_nexa_admin', 'username')->ignore($id, 'id'),
            ],
            'phone' => [
                'required', 'digits:10',
                Rule::unique('tbl_nexa_admin', 'phone')->ignore($id, 'id'),
            ],
            'email' => [
                'required', 'email', 'min:5',
                Rule::unique('tbl_nexa_admin', 'email')->ignore($id, 'id'),
            ],
            'role'       => 'required|in:super_admin,admin,staff',
            'avatar_url' => 'nullable|image|mimes:jpeg,png,jpg|max:5120',
        ], $messages);

        if ($validator->fails()) {
            return redirect('admin/' . $id)
                ->withErrors($validator)
                ->withInput();
        }

        try {
            $admin = AdminModel::findOrFail($id);

            if ($request->hasFile('avatar_url')) {
                if ($admin->avatar_url) {
                    Storage::disk('public')->delete($admin->avatar_url);
                }
                $imagePath = $request->file('avatar_url')->store('uploads/admin', 'public');
                $admin->avatar_url = $imagePath;
            }

            $admin->full_name        = strip_tags($request->full_name);
            $admin->username         = strip_tags($request->username);
            $admin->phone            = strip_tags($request->phone);
            $admin->email            = strip_tags($request->email);
            $admin->role             = strip_tags($request->role);
            $admin->is_login_allowed = $request->has('is_login_allowed');

            $admin->save();

            Alert::success('ปรับปรุงข้อมูลสำเร็จ');
            return redirect('/admin');
        } catch (\Exception $e) {
            return view('errors.404');
        }
    }

    public function remove($id)
    {
        try {
            $admin = AdminModel::find($id);

            if (!$admin) {
                Alert::error('admin not found.');
                return redirect('admin');
            }

            if ($admin->avatar_url && Storage::disk('public')->exists($admin->avatar_url)) {
                Storage::disk('public')->delete($admin->avatar_url);
            }

            $admin->delete();

            Alert::success('ลบข้อมูลสําเร็จ');
            return redirect('/admin');
        } catch (\Exception $e) {
            Alert::error('เกิดข้อผิดพลาด: ' . $e->getMessage());
            return redirect('/admin');
        }
    }

    public function reset($id)
    {
        try {
            $admin = AdminModel::findOrFail($id);
            if (isset($admin)) {
                $id       = $admin->id;
                $username = $admin->username;
                $email    = $admin->email;

                return view('admin.editPassword', compact('id', 'username', 'email'));
            }
        } catch (\Exception $e) {
            return view('errors.404');
        }
    }

    public function resetPassword($id, Request $request)
    {
        $messages = [
            'password.required' => 'กรุณากรอกข้อมูล',
            'password.min' => 'กรอกข้อมูลขั้นต่ำ :min ตัวอักษร',
            'password.confirmed' => 'รหัสผ่านไม่ตรงกัน',
            'password_confirmation.required' => 'กรุณากรอกข้อมูล',
            'password_confirmation.min' => 'กรอกข้อมูลขั้นต่ำ :min ตัวอักษร',
        ];

        $validator = Validator::make($request->all(), [
            'password' => 'required|min:8|confirmed',
            'password_confirmation' => 'required|min:8',
        ], $messages);

        if ($validator->fails()) {
            return redirect('admin/reset/' . $id)
                ->withErrors($validator)
                ->withInput();
        }

        try {
            $admin = AdminModel::find($id);
            $admin->update([
                'password_hash' => bcrypt($request->input('password')),
            ]);

            Alert::success('ปรับปรุงข้อมูลสำเร็จ');
            return redirect('/admin');
        } catch (\Exception $e) {
            return view('errors.404');
        }
    }
}