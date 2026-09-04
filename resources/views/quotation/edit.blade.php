@extends('home')

@section('content')

<div class="container-fluid mt-4">

    <div class="card shadow border-0">

        <div class="card-header text-white d-flex justify-content-between align-items-center">
            <h4 class="mb-0">
                <i class="fas fa-file-invoice me-2"></i>
                ฟอร์มแก้ไขใบเสนอราคา
            </h4>
        </div>

        <div class="card-body">

<form action="/quotation/{{ $quotation->quotation_id }}" method="post">
@csrf
@method('PUT')

<div class="row g-3">

    <div class="col-md-4">
        <label>เลขที่ใบเสนอราคา</label>
        <input type="text" class="form-control" name="quotation_no" readonly
            value="{{ old('quotation_no', $quotation->quotation_no) }}">
        @if($errors->has('quotation_no'))
            <div class="text-danger small">{{ $errors->first('quotation_no') }}</div>
        @endif
    </div>

    <div class="col-md-4">
        <label>วันที่</label>
        <input type="date" class="form-control" name="quotation_date"
            value="{{ old('quotation_date', $quotation->quotation_date ? \Carbon\Carbon::parse($quotation->quotation_date)->format('Y-m-d') : '') }}">
        @if($errors->has('quotation_date'))
            <div class="text-danger small">{{ $errors->first('quotation_date') }}</div>
        @endif
    </div>

    <div class="col-md-4">
        <label>กำหนดยืนราคา (วัน)</label>
        <input type="number" class="form-control" name="price_validity_days" min="0"
            value="{{ old('price_validity_days', $quotation->price_validity_days) }}">
        @if($errors->has('price_validity_days'))
            <div class="text-danger small">{{ $errors->first('price_validity_days') }}</div>
        @endif
    </div>

</div>

<div class="mb-3 mt-3">
    <label class="form-label">เรียน (ลูกค้า/หน่วยงาน)</label>

    <div class="row g-2 align-items-center">
        <div class="col">
            <select class="form-select" name="customer_id" id="customer_id">
                <option value="">เลือก</option>
                @foreach($customers as $cus)
                    <option value="{{ $cus->customer_id }}" {{ (old('customer_id', $quotation->customer_id) == $cus->customer_id) ? 'selected' : '' }}>
                        {{ $cus->customer_name }}
                    </option>
                @endforeach
            </select>
        </div>
        <div class="col-auto">
            <button type="button" class="btn btn-outline-warning remove-row-btn remove-row" data-bs-toggle="modal" data-bs-target="#addCustomerModal">
                เพิ่ม
            </button>
        </div>
    </div>

    @if($errors->has('customer_id'))
        <div class="text-danger small mt-1">{{ $errors->first('customer_id') }}</div>
    @endif
</div>

<div class="mb-3">
    <label>เรื่อง</label>
    <input type="text" class="form-control" name="subject"
        value="{{ old('subject', $quotation->subject) }}">
    @if($errors->has('subject'))
        <div class="text-danger small">{{ $errors->first('subject') }}</div>
    @endif
</div>

<div class="mb-3">
    <label class="fw-bold">รายการสินค้า</label>

    <div id="item-rows">
        @php
            $existingItems = old('items', $quotation->details->map(function ($d) {
                return [
                    'product_id'  => $d->product_id,
                    'description' => $d->description,
                    'quantity'    => $d->quantity,
                    'unit'        => $d->unit,
                    'unit_price'  => $d->unit_price,
                ];
            })->toArray());
        @endphp

        @foreach($existingItems as $index => $item)
            <div class="item-row border rounded p-3 mb-3">
                <div class="row g-2 align-items-end">
                    <div class="col-md-4">
                        <label class="form-label small text-muted mb-1">สินค้า</label>
                        <select class="form-select" name="items[{{ $index }}][product_id]">
                            <option value="">เลือกสินค้า</option>
                            @foreach($products as $p)
                                <option value="{{ $p->product_id }}" {{ ($item['product_id'] ?? '') == $p->product_id ? 'selected' : '' }}>
                                    {{ $p->product_name }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-2">
                        <label class="form-label small text-muted mb-1">จำนวน</label>
                        <input type="number" step="0.01" min="0.01" class="form-control" name="items[{{ $index }}][quantity]"
                            placeholder="จำนวน" value="{{ $item['quantity'] ?? '' }}">
                    </div>
                    <div class="col-md-2">
                        <label class="form-label small text-muted mb-1">หน่วย</label>
                        <input type="text" class="form-control" name="items[{{ $index }}][unit]" placeholder="หน่วย"
                            value="{{ $item['unit'] ?? '' }}">
                    </div>
                    <div class="col-md-3">
                        <label class="form-label small text-muted mb-1">ราคา/หน่วย</label>
                        <input type="number" step="0.01" min="0" class="form-control" name="items[{{ $index }}][unit_price]"
                            placeholder="ราคา/หน่วย" value="{{ $item['unit_price'] ?? '' }}">
                    </div>
                    <div class="col-md-1 text-end">
                        <button type="button" class="btn btn-outline-danger remove-row-btn remove-item">ลบ</button>
                    </div>
                </div>

                <div class="row g-2 mt-1">
                    <div class="col-12">
                        <label class="form-label small text-muted mb-1">รายละเอียด/สเปคสินค้า</label>
                        <textarea class="form-control" name="items[{{ $index }}][description]" rows="2"
                            placeholder="เช่น ขนาด กว้าง 9&quot; สูง 11&quot; ขยายข้าง 4&quot; / วัสดุผ้า 600D / สกรีนไม่จำกัดสี 1 ตำแหน่ง">{{ $item['description'] ?? '' }}</textarea>
                    </div>
                </div>
            </div>
        @endforeach
    </div>

    <button type="button" id="add-item-row" class="btn btn-outline-secondary btn-sm mt-1">+ เพิ่มรายการสินค้า</button>

    @if($errors->has('items'))
        <div class="text-danger small mt-1">{{ $errors->first('items') }}</div>
    @endif
</div>

<div class="row g-3">

    <div class="col-md-4">
        <label>ภาษีมูลค่าเพิ่ม (%)</label>
        <input type="number" step="0.01" min="0" max="100" class="form-control" name="vat_rate"
            value="{{ old('vat_rate', $quotation->vat_rate) }}">
        @if($errors->has('vat_rate'))
            <div class="text-danger small">{{ $errors->first('vat_rate') }}</div>
        @endif
    </div>

    <div class="col-md-8">
        <label>เงื่อนไขการชำระเงิน</label>
        <input type="text" class="form-control" name="payment_terms"
            value="{{ old('payment_terms', $quotation->payment_terms) }}">
        @if($errors->has('payment_terms'))
            <div class="text-danger small">{{ $errors->first('payment_terms') }}</div>
        @endif
    </div>

</div>

<div class="row g-3 mt-1">

    <div class="col-md-4">
        <label>สถานะ</label>
        @php
            $statusOptions = [
                'draft'    => 'ฉบับร่าง',
                'sent'     => 'ส่งแล้ว',
                'approved' => 'อนุมัติแล้ว',
                'rejected' => 'ไม่อนุมัติ',
            ];
        @endphp
        <select class="form-select" name="status">
            @foreach($statusOptions as $value => $label)
                <option value="{{ $value }}" {{ old('status', $quotation->status) == $value ? 'selected' : '' }}>
                    {{ $label }}
                </option>
            @endforeach
        </select>
        @if($errors->has('status'))
            <div class="text-danger small">{{ $errors->first('status') }}</div>
        @endif
    </div>

</div>

@if($errors->has('error'))
    <div class="text-danger small mt-3">{{ $errors->first('error') }}</div>
@endif

<div class="d-flex gap-2 mt-4 justify-content-end">
    <a href="/quotation/{{ $quotation->quotation_id }}/print" target="_blank" class="btn btn-submit-gradient">
        <i class="fas fa-print me-1"></i> พิมพ์ใบเสนอราคา
    </a>
    <button type="submit" class="btn btn-submit-gradient">บันทึกการแก้ไข</button>
    <a href="/quotation" class="btn btn-cancel-gradient text-center">ยกเลิก</a>
</div>

</form>

        </div>

    </div>

</div>

<!-- Modal เพิ่มลูกค้า/หน่วยงาน -->
<div class="modal fade @if($errors->hasBag('customer')) show @endif" id="addCustomerModal" tabindex="-1" @if($errors->hasBag('customer')) style="display:block" @endif>
  <div class="modal-dialog">
    <div class="modal-content">
      <form action="/customer" method="post">
        @csrf
        <div class="modal-header">
          <h5 class="modal-title">เพิ่มลูกค้า/หน่วยงานใหม่</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
        </div>
        <div class="modal-body">
            <div class="mb-3">
                <label>ชื่อลูกค้า/หน่วยงาน</label>
                <input type="text" class="form-control" name="customer_name" required minlength="2" placeholder="เช่น แรงงานจังหวัดชัยนาท">
                <div class="text-danger small customer-name-error"></div>
            </div>
            <div class="mb-3">
                <label>ที่อยู่</label>
                <textarea class="form-control" name="address" rows="2"></textarea>
            </div>
            <div class="mb-3">
                <label>เบอร์โทร</label>
                <input type="text" class="form-control" name="tel">
            </div>
        </div>
        <div class="modal-footer">
          <button type="submit" class="btn btn-submit-gradient">บันทึกลูกค้า</button>
          <button type="button" class="btn btn-cancel-gradient" data-bs-dismiss="modal">ยกเลิก</button>
        </div>
      </form>
    </div>
  </div>
</div>

@endsection

@section('js_before')
<script>
// ===== รายการสินค้า: เพิ่มแถว =====
document.getElementById('add-item-row').addEventListener('click', function () {
    const wrapper = document.getElementById('item-rows');
    const row = wrapper.querySelector('.item-row').cloneNode(true);
    const newIndex = wrapper.querySelectorAll('.item-row').length;

    row.querySelectorAll('input, select, textarea').forEach(el => {
        if (el.name) {
            // แทนที่ index เดิม (เช่น items[0][xxx]) ด้วย index ใหม่
            el.name = el.name.replace(/items\[\d+\]/, `items[${newIndex}]`);
        }
        if (el.tagName === 'SELECT') {
            el.selectedIndex = 0;
        } else {
            el.value = '';
        }
    });

    wrapper.appendChild(row);
});

// ===== รายการสินค้า: ลบแถว (event delegation) =====
document.getElementById('item-rows').addEventListener('click', function (e) {
    if (e.target.classList.contains('remove-item')) {
        const rows = document.querySelectorAll('.item-row');
        if (rows.length > 1) e.target.closest('.item-row').remove();
    }
});

// ===== เพิ่มลูกค้าใหม่ผ่าน modal ด้วย AJAX (ไม่รีโหลดหน้า) =====
const customerSelect = document.getElementById('customer_id');
const addCustomerForm = document.querySelector('#addCustomerModal form');
const customerNameInput = addCustomerForm.querySelector('input[name="customer_name"]');
const customerNameError = addCustomerForm.querySelector('.customer-name-error');

addCustomerForm.addEventListener('submit', function (e) {
    e.preventDefault(); // กันไม่ให้หน้ารีโหลด ซึ่งจะทำให้ข้อมูลในฟอร์มใบเสนอราคาหายหมด

    const formData = new FormData(addCustomerForm);
    const submitBtn = addCustomerForm.querySelector('button[type="submit"]');
    submitBtn.disabled = true;
    customerNameError.textContent = '';

    fetch(addCustomerForm.action, {
        method: 'POST',
        headers: {
            'X-Requested-With': 'XMLHttpRequest',
            'Accept': 'application/json',
        },
        body: formData,
    })
    .then(async (res) => {
        const data = await res.json();
        if (!res.ok) throw data;
        return data;
    })
    .then((customer) => {
        const option = document.createElement('option');
        option.value = customer.customer_id;
        option.textContent = customer.customer_name;
        option.selected = true;
        customerSelect.appendChild(option);

        addCustomerForm.reset();
        bootstrap.Modal.getInstance(document.getElementById('addCustomerModal')).hide();
    })
    .catch((err) => {
        customerNameError.textContent = err?.errors?.customer_name?.[0] || 'บันทึกลูกค้าไม่สำเร็จ';
    })
    .finally(() => {
        submitBtn.disabled = false;
    });
});
</script>
@endsection