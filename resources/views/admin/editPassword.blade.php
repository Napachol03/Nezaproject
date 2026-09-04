@extends('home')

@section('content')

<div class="form-card">
    <h3>เปลี่ยนรหัสผ่านผู้ดูแลระบบ</h3>

<form action="/admin/reset/{{ $id }}" method="post">
@csrf
@method('put')

<div class="mb-3">
    <label>ชื่อผู้ใช้งาน</label>
    <input type="text" class="form-control" name="username" disabled placeholder="username" value="{{ $username }}">
</div>

<div class="mb-3">
    <label>อีเมล</label>
    <input type="email" class="form-control" name="email" disabled placeholder="email" value="{{ $email }}"  >
</div>

<div class="mb-3">
    <label>รหัสผ่านใหม่</label>
    <input type="password" class="form-control" name="password" placeholder="รหัสผ่านใหม่ อย่างน้อย 8 ตัวอักษร"  >
    @if($errors->has('password'))
        <div class="text-danger small"> {{ $errors->first('password') }}</div>
    @endif
</div>

<div class="mb-3">
    <label>ยืนยันรหัสผ่านใหม่</label>
    <input type="password" class="form-control" name="password_confirmation" placeholder="ยืนยันรหัสผ่านใหม่" >
    @if($errors->has('password_confirmation'))
        <div class="text-danger small"> {{ $errors->first('password_confirmation') }}</div>
    @endif
</div>

<div class="d-flex gap-2 mt-2 justify-content-end">
    <button type="submit" class="btn btn-submit-gradient">Update</button>
    <a href="/admin" class="btn btn-cancel-gradient text-center">ยกเลิก</a>
</div>

</form>
</div>

@endsection

@section('footer')
@endsection

@section('js_before')
@endsection