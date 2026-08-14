@extends('home')

@section('content')
    <div class="form-card">
        <h3>ฟอร์มเพิ่มผู้ดูแลระบบ</h3>

        <form action="/admin" method="post" enctype="multipart/form-data">
            @csrf

            <div class="mb-3">
                <label>ชื่อ-นามสกุล</label>
                <input type="text" class="form-control" name="full_name" value="{{ old('full_name') }}"
                    placeholder="Full Name">
                @if ($errors->has('full_name'))
                    <div class="text-danger small"> {{ $errors->first('full_name') }}</div>
                @endif
            </div>

            <div class="mb-3">
                <label>ชื่อผู้ใช้งาน</label>
                <input type="text" class="form-control" name="username" placeholder="Username" minlength="3"
                    value="{{ old('username') }}">
                @if ($errors->has('username'))
                    <div class="text-danger small"> {{ $errors->first('username') }}</div>
                @endif
            </div>

            <div class="mb-3">
                <label>รหัสผ่าน</label>
                <input type="password" class="form-control" name="password" placeholder="Password" minlength="8" value="{{ old('password') }}">
                @if ($errors->has('password'))
                    <div class="text-danger small">{{ $errors->first('password') }}</div>
                @endif
            </div>
            
            <div class="mb-3">
                <label>อีเมล</label>
                <input type="email" class="form-control" name="email" placeholder="Email" value="{{ old('email') }}">
                @if ($errors->has('email'))
                    <div class="text-danger small"> {{ $errors->first('email') }}</div>
                @endif
            </div>

            <div class="mb-3">
                <label>เบอร์โทรศัพท์</label>
                <input type="text" class="form-control" name="phone" placeholder="Phone" value="{{ old('phone') }}"
                    pattern="\d{10}">
                @if ($errors->has('phone'))
                    <div class="text-danger small"> {{ $errors->first('phone') }}</div>
                @endif
            </div>

            <div class="mb-3">
                <label>สิทธิ์การใช้งาน</label>
                <select class="form-select" name="role">
                    <option value="" disabled {{ old('role') ? '' : 'selected' }}>-- เลือกสิทธิ์ --</option>
                    <option value="admin" {{ old('role') == 'admin' ? 'selected' : '' }}>Admin</option>
                </select>
                @if ($errors->has('role'))
                    <div class="text-danger small"> {{ $errors->first('role') }}</div>
                @endif
            </div>
            <div class="mb-3">
                <div class="form-check">
                    <input type="checkbox" class="form-check-input" id="is_login_allowed" name="is_login_allowed"
                        value="1" {{ old('is_login_allowed') ? 'checked' : '' }}>
                    <label class="form-check-label" for="is_login_allowed">อนุญาตให้ล็อกอินเข้าระบบ</label>
                </div>
            </div>

            <div class="mb-3">
                <label>รูปโปรไฟล์</label>
                <input type="file" class="form-control" name="avatar_url" accept="image/*">
                @if ($errors->has('avatar_url'))
                    <div class="text-danger small"> {{ $errors->first('avatar_url') }}</div>
                @endif
            </div>

            <div class="d-flex gap-2 mt-2 justify-content-end">
                <button type="submit" class="btn btn-submit-gradient">เพิ่มแอดมิน</button>
                <a href="/admin" class="btn btn-cancel-gradient text-center">ยกเลิก</a>
            </div>

        </form>
    </div>
@endsection

@section('footer')
@endsection

@section('js_before')
@endsection
