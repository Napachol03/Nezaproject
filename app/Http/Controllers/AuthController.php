<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\AdminModel;

class AuthController extends Controller
{
    public function index(Request $request)
    {
        $secretKey = config('app.login_secret_key');
        $providedKey = $request->query('key');

        if (empty($secretKey) || $providedKey !== $secretKey) {
            abort(404);
        }

        return view('auth.login', ['key' => $providedKey]);
    }

    public function login(Request $request)
    {
        $secretKey = config('app.login_secret_key');
        $providedKey = $request->input('key');

        if (empty($secretKey) || $providedKey !== $secretKey) {
            abort(404);
        }

        $credentials = $request->validate([
            'username'      => 'required|max:100',
            'password_hash' => 'required|string|min:3',
        ], [
            'username.required'      => 'กรุณากรอกข้อมูล',
            'password_hash.required' => 'กรุณากรอกข้อมูล',
            'password_hash.min'      => 'กรอกข้อมูลขั้นต่ำ :min ตัว',
        ]);

        // ดึงข้อมูล admin จาก username ที่กรอกมา
        $admin = AdminModel::where('username', $credentials['username'])->first();

        // เช็คว่าเจอ record ไหม และ is_login_allowed ต้องเป็น true เท่านั้น
        if (!$admin || !$admin->is_login_allowed) {
            return back()
                ->withErrors(['username' => 'ชื่อผู้ใช้หรือรหัสผ่านไม่ถูกต้อง'])
                ->withInput(['key' => $providedKey]);
        }

        if (Auth::guard('admin')->attempt([
            'username' => $credentials['username'],
            'password' => $credentials['password_hash'],
        ])) {
            $request->session()->regenerate();
            session(['username' => Auth::guard('admin')->user()->username]);
            session(['id' => Auth::guard('admin')->user()->id]);
            $admin->update(['last_login_at' => now()]);
            return redirect()->intended('/dashboard');
        }

        return back()
            ->withErrors(['username' => 'ชื่อผู้ใช้หรือรหัสผ่านไม่ถูกต้อง'])
            ->withInput(['key' => $providedKey]);
    }

    public function logout(Request $request)
    {
        Auth::guard('admin')->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/');
    }
}