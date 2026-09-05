@extends('home')

@section('content')

<div class="form-card">
    <h3>ฟอร์มแก้ไขผู้ดูแลระบบ</h3>

<<<<<<< HEAD
<form action="/admin/{{ $id }}" method="post" >
=======
<form action="/admin/{{ $id }}" method="post" enctype="multipart/form-data">
>>>>>>> 19bea7484cccea031972b54bada982e94bcc8b3c
@csrf
@method('put')

<div class="mb-3">
    <label>ชื่อ-นามสกุล</label>
    <input type="text" class="form-control" name="full_name" placeholder="Full Name" value="{{ old('full_name', $full_name) }}">
    @if($errors->has('full_name'))
        <div class="text-danger small"> {{ $errors->first('full_name') }}</div>
    @endif
</div>

<div class="mb-3">
    <label>ชื่อผู้ใช้งาน</label>
    <input type="text" class="form-control" name="username" placeholder="Username" value="{{ old('username', $username) }}">
    @if($errors->has('username'))
        <div class="text-danger small"> {{ $errors->first('username') }}</div>
    @endif
</div>

<div class="mb-3">
    <label>อีเมล</label>
    <input type="email" class="form-control" name="email" placeholder="Email" value="{{ old('email', $email) }}">
    @if($errors->has('email'))
        <div class="text-danger small"> {{ $errors->first('email') }}</div>
    @endif
</div>

<div class="mb-3">
    <label>เบอร์โทรศัพท์</label>
    <input type="text" class="form-control" name="phone" placeholder="Phone" value="{{ old('phone', $phone) }}" pattern="\d{10}">
    <small class="form-text text-muted">กรุณากรอกเบอร์โทรศัพท์ 10 หลัก</small>
    @if($errors->has('phone'))
        <div class="text-danger small"> {{ $errors->first('phone') }}</div>
    @endif
</div>

<div class="mb-3">
    <label>สิทธิ์การใช้งาน</label>
    <select class="form-select" name="role">
        <option value="" disabled>-- เลือกสิทธิ์ --</option>
        <option value="admin" {{ old('role', $role) == 'admin' ? 'selected' : '' }}>Admin</option>
    </select>
    @if($errors->has('role'))
        <div class="text-danger small"> {{ $errors->first('role') }}</div>
    @endif
</div>
<div class="mb-3">
    <div class="form-check">
        <input type="checkbox" class="form-check-input" id="is_login_allowed" name="is_login_allowed" value="1" {{ old('is_login_allowed', $is_login_allowed) ? 'checked' : '' }}>
        <label class="form-check-label" for="is_login_allowed">อนุญาตให้ล็อกอินเข้าระบบ</label>
    </div>
</div>

<div class="mb-3">
    <label>รูปโปรไฟล์ปัจจุบัน</label>
    <div>
        @if (!empty($avatar_url))
            <img src="{{ asset('storage/' . $avatar_url) }}" width="120" style="border-radius: 8px;">
        @else
            <p class="text-muted">ไม่มีรูปภาพ</p>
        @endif
    </div>
</div>
<div class="mb-3">
    <label>เปลี่ยนรูปโปรไฟล์</label>
    <input type="file" class="form-control" name="avatar_url" accept="image/*">
    <small class="text-muted">ไม่เลือกไฟล์ = ใช้รูปเดิมต่อ</small>
    @if($errors->has('avatar_url'))
        <div class="text-danger small"> {{ $errors->first('avatar_url') }}</div>
    @endif
</div>

<div class="d-flex gap-2 mt-2 justify-content-end">
<<<<<<< HEAD
    <button type="submit" class="btn btn-submit-gradient">บันทึก</button>
=======
    <button type="submit" class="btn btn-submit-gradient">บันทึกข้อมูล</button>
>>>>>>> 19bea7484cccea031972b54bada982e94bcc8b3c
    <a href="/admin" class="btn btn-cancel-gradient text-center">ยกเลิก</a>
</div>

</form>
</div>

@endsection

@section('footer')
@endsection

@section('js_before')
@endsection