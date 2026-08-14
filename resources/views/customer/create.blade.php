@extends('home')

@section('content')

<div class="form-card">
    <h3>ฟอร์มเพิ่มลูกค้า</h3>

<form action="/customer/" method="post">
@csrf

<div class="mb-3">
    <label>ชื่อลูกค้า/หน่วยงาน</label>
    <input type="text" class="form-control" name="customer_name" request placeholder="ชื่อลูกค้า/หน่วยงาน" minlength="3" value="{{ old('customer_name') }}">
    @if($errors->has('customer_name'))
        <div class="text-danger small"> {{ $errors->first('customer_name') }}</div>
    @endif
</div>

<div class="mb-3">
    <label>ที่อยู่</label>
    <textarea class="form-control" name="address" rows="3" request placeholder="ที่อยู่">{{ old('address') }}</textarea>
    @if($errors->has('address'))
        <div class="text-danger small"> {{ $errors->first('address') }}</div>
    @endif
</div>

<div class="mb-3">
    <label>เบอร์โทร</label>
    <input type="text" class="form-control" name="tel" request placeholder="เบอร์โทร" value="{{ old('tel') }}">
    @if($errors->has('tel'))
        <div class="text-danger small"> {{ $errors->first('tel') }}</div>
    @endif
</div>

<div class="d-flex gap-2 mt-2 justify-content-end">
    <button type="submit" class="btn btn-submit-gradient">เพิ่มข้อมูล</button>
    <a href="/customer" class="btn btn-cancel-gradient text-center">ยกเลิก</a>
</div>
</form>
</div>

@endsection