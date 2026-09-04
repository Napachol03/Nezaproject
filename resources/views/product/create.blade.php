@extends('home')

@section('content')

<div class="form-card">
    <h3>{{ isset($product) ? 'ฟอร์มแก้ไขสินค้า' : 'ฟอร์มเพิ่มสินค้า' }}</h3>

<form id="productForm" action="{{ isset($product) ? '/product/'.$product->id : '/product' }}" method="post" enctype="multipart/form-data">
@csrf
@if(isset($product))
    @method('PUT')
@endif

<div class="mb-3">
    <label>ชื่อสินค้า</label>
    <input type="text" class="form-control" name="product_name" placeholder="ชื่อสินค้า" minlength="3" value="{{ old('product_name', $product->product_name ?? '') }}">
    @if($errors->has('product_name'))
        <div class="text-danger small"> {{ $errors->first('product_name') }}</div>
    @endif
</div>

<div class="mb-3">
    <label>รายละเอียด</label>
    <textarea class="form-control" name="description" rows="10" placeholder="รายละเอียดสินค้า">{{ old('description', $product->description ?? '') }}</textarea>
    @if($errors->has('description'))
        <div class="text-danger small"> {{ $errors->first('description') }}</div>
    @endif
</div>

<div class="mb-3">
    <label class="form-label">หมวดหมู่</label>

    <div class="row g-2 align-items-center">
        <div class="col">
            <select class="form-select" name="category_id" id="category_id">
                <option value="">เลือก</option>
                @foreach($categories as $cat)
                    <option value="{{ $cat->category_id }}" {{ (old('category_id', $product->category_id ?? session('new_category_id')) == $cat->category_id) ? 'selected' : '' }}>
                        {{ $cat->category_name }}
                    </option>
                @endforeach
            </select>
        </div>
        <div class="col-auto">
            <button type="button" class="btn btn-outline-warning remove-row-btn remove-row" data-bs-toggle="modal" data-bs-target="#addCategoryModal">
                เพิ่ม
            </button>
        </div>
    </div>

    @if($errors->has('category_id'))
        <div class="text-danger small mt-1">{{ $errors->first('category_id') }}</div>
    @endif
</div>

<div class="mb-3">
    <div class="form-check">
        <input type="checkbox" class="form-check-input" name="is_featured" id="is_featured" value="1" {{ old('is_featured', $product->is_featured ?? false) ? 'checked' : '' }}>
        <label class="form-check-label" for="is_featured">สินค้าเด่น (Featured)</label>
    </div>
    <div class="form-check">
        <input type="checkbox" class="form-check-input" name="is_active" id="is_active" value="1" {{ old('is_active', $product->is_active ?? true) ? 'checked' : '' }}>
        <label class="form-check-label" for="is_active">แสดงบนเว็บ (Active)</label>
    </div>
</div>

<div class="mb-3">
    <label>สเปกสินค้า</label>
    <div id="attribute-rows">
        <div class="row mb-2 attribute-row g-2">
            <div class="col-5">
                <input type="text" class="form-control" name="attribute_key[]" placeholder="เช่น สี, ไซส์" list="attribute-key-list">
            </div>
            <div class="col-5">
                <input type="text" class="form-control" name="attribute_value[]" placeholder="เช่น ดำ, M" list="attribute-value-list">
            </div>
            <div class="col-2">
                <button type="button" class="btn btn-outline-danger remove-row-btn remove-row">ลบ</button>
            </div>
        </div>
    </div>
    <button type="button" id="add-attribute-row" class="btn btn-outline-secondary btn-sm mt-1">+ เพิ่มสเปก</button>
</div>

<datalist id="attribute-key-list">
    @foreach($usedKeys as $key)
        <option value="{{ $key }}">
    @endforeach
</datalist>

<datalist id="attribute-value-list">
    @foreach($usedValues as $value)
        <option value="{{ $value }}">
    @endforeach
</datalist>

<div class="mb-3">
    <div class="d-flex justify-content-between align-items-center mb-2">
        <label class="form-label fw-bold m-0">จัดการรูปภาพ</label>
        <button type="button" class="btn btn-link text-danger p-0 text-decoration-none" data-bs-toggle="modal" data-bs-target="#manageImageModal">
            เพิ่มรูป
        </button>
    </div>

    <!-- แสดงตัวอย่างรูปภาพ (sync กับ modal ทุกครั้งที่กด "ตกลง") -->
    <div class="row g-2" id="existing-images">
        @if(isset($product) && $product->images && $product->images->count() > 0)
            @foreach($product->images->sortBy('sort_order') as $img)
                <div class="col-auto text-center" data-image-id="{{ $img->image_id }}">
                    <img src="{{ $img->image_url }}" width="90" height="90" style="object-fit: cover; border-radius: 8px;" class="border">
                </div>
            @endforeach
        @else
            <span class="text-muted small" id="no-images-msg">ยังไม่มีรูปภาพ</span>
        @endif
    </div>

    <!-- hidden inputs (delete_images[], image_order[], primary_image_id) จะถูกสร้างตอน submit -->
    <div id="image-hidden-inputs"></div>
    <div class="text-danger small" id="images-error"></div>
</div>

<div class="mb-3">
    <!-- input จริงที่ controller อ่านค่า images[] จาก request -->
    <input type="file" class="form-control" name="images[]" id="main-images-input" multiple accept="image/*" hidden>
    <small class="text-muted d-block">เพิ่ม/จัดเรียง/ลบรูปภาพได้ผ่านปุ่ม "เพิ่มรูป" ด้านบน</small>
</div>

<div class="d-flex gap-2 mt-2 justify-content-end">
    <button type="submit" class="btn btn-submit-gradient">เพิ่มข้อมูล</button>
    <a href="/product" class="btn btn-cancel-gradient text-center">ยกเลิก</a>
</div>
</form>
</div>

<!-- Modal เพิ่มหมวดหมู่ -->
<!-- แก้ไข: form นี้เดิมเป็น POST ธรรมดา -> full page reload -> ข้อมูล form สินค้าหลักหาย
     และ modal auto-reopen script (DOMContentLoaded) ทำให้ error กลางสคริปต์จนปุ่มยกเลิกกดไม่ออก
     แก้โดยเปลี่ยนเป็น AJAX submit ทั้งหมด ไม่มี reload เลย -->
<div class="modal fade" id="addCategoryModal" tabindex="-1">
  <div class="modal-dialog">
    <div class="modal-content">
      <form id="categoryForm" action="/category" method="post">
        @csrf
        <div class="modal-header">
          <h5 class="modal-title">เพิ่มหมวดหมู่ใหม่</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
        </div>
        <div class="modal-body">
            <div class="mb-3">
                <label>ชื่อหมวดหมู่</label>
                <input type="text" class="form-control" name="category_name" id="category_name_input"
                       required minlength="2" placeholder="เช่น เสื้อ, ร่ม, กระเป๋า">
                <div class="text-danger small" id="category_name_error"></div>
            </div>
        </div>
        <div class="modal-footer">
          <button type="submit" class="btn btn-submit-gradient">บันทึกหมวดหมู่</button>
          <button type="button" class="btn btn-cancel-gradient" data-bs-dismiss="modal">ยกเลิก</button>
        </div>
      </form>
    </div>
  </div>
</div>

<!-- Modal เพิ่มและจัดลำดับรูป -->
<div class="modal fade" id="manageImageModal" tabindex="-1">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">จัดการรูปภาพ</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
      </div>
      <div class="modal-body">
        <p class="text-muted small mb-2">ลากรูปเพื่อจัดเรียงลำดับ คลิก "ลบ" เพื่อลบรูป หรือกด "+ เพิ่มรูป" เพื่อเพิ่มรูปใหม่ (คลิกดาวเพื่อตั้งเป็นรูปหลัก)</p>

        <div class="row g-3" id="sortable-images">
            @if(isset($product) && $product->images)
                @foreach($product->images->sortBy('sort_order') as $img)
                <div class="col-auto image-manage-item" draggable="true" data-type="existing" data-image-id="{{ $img->image_id }}">
                    <div class="position-relative border rounded p-1" style="width:100px;">
                        <span class="badge bg-dark position-absolute top-0 start-0 m-1 order-badge">{{ $loop->iteration }}</span>
                        <span class="position-absolute top-0 end-0 m-1 set-primary-btn" style="cursor:pointer;font-size:18px;" title="ตั้งเป็นรูปหลัก">
                            {{ $img->is_primary ? '⭐' : '☆' }}
                        </span>
                        <img src="{{ $img->image_url }}" width="90" height="90" style="object-fit:cover;border-radius:6px;display:block;">
                    </div>
                    <div class="text-center mt-1">
                        <a href="#" class="text-danger small delete-image-item">ลบ</a>
                    </div>
                </div>
                @endforeach
            @endif

            <div class="col-auto d-flex align-items-center justify-content-center" id="add-image-slot" style="width:100px; height:90px; cursor:pointer;">
                <div class="border rounded d-flex align-items-center justify-content-center text-muted" style="width:100%; height:100%;">
                    + เพิ่มรูป
                </div>
            </div>
        </div>

        <input type="file" id="modal-image-input" accept="image/*" multiple hidden>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-submit-gradient" id="applyImageChanges" data-bs-dismiss="modal">ตกลง</button>
        <button type="button" class="btn btn-cancel-gradient" data-bs-dismiss="modal">ยกเลิก</button>
    </div>
    </div>
  </div>
</div>

@endsection

@section('js_before')
<script>
document.getElementById('add-attribute-row').addEventListener('click', function () {
    const wrapper = document.getElementById('attribute-rows');
    const row = wrapper.querySelector('.attribute-row').cloneNode(true);
    row.querySelectorAll('input').forEach(input => input.value = '');
    wrapper.appendChild(row);
});

document.getElementById('attribute-rows').addEventListener('click', function (e) {
    if (e.target.classList.contains('remove-row')) {
        const rows = document.querySelectorAll('.attribute-row');
        if (rows.length > 1) e.target.closest('.attribute-row').remove();
    }
});

const categorySelect = document.getElementById('category_id');
categorySelect.addEventListener('change', function () {
    if (this.value === '__add_new__') {
        this.value = '';
        const modal = new bootstrap.Modal(document.getElementById('addCategoryModal'));
        modal.show();
    }
});

// ------------------------------------------------------------------
// เพิ่มหมวดหมู่ใหม่แบบ AJAX (ไม่ reload หน้า -> form สินค้าหลักไม่หาย)
// ------------------------------------------------------------------
const categoryForm = document.getElementById('categoryForm');
const addCategoryModalEl = document.getElementById('addCategoryModal');

categoryForm.addEventListener('submit', function (e) {
    e.preventDefault();

    const errorBox = document.getElementById('category_name_error');
    errorBox.textContent = '';

    const submitBtn = categoryForm.querySelector('button[type="submit"]');
    const originalText = submitBtn.textContent;
    submitBtn.disabled = true;
    submitBtn.textContent = 'กำลังบันทึก...';

    fetch(categoryForm.action, {
        method: 'POST',
        headers: {
            'X-Requested-With': 'XMLHttpRequest',
            'Accept': 'application/json',
        },
        body: new FormData(categoryForm),
    })
    .then(async (res) => {
        let data = {};
        try {
            data = await res.json();
        } catch (_) {
            // ไม่ใช่ JSON (เช่น error 500 คืน HTML)
        }

        if (res.ok && data.success) {
            // เพิ่ม option ใหม่เข้า select แล้วเลือกให้ทันที
            const opt = document.createElement('option');
            opt.value = data.category.category_id;
            opt.textContent = data.category.category_name;
            opt.selected = true;
            categorySelect.appendChild(opt);

            bootstrap.Modal.getOrCreateInstance(addCategoryModalEl).hide();
            categoryForm.reset();
        } else if (res.status === 422 && data.errors && data.errors.category_name) {
            errorBox.textContent = data.errors.category_name[0];
        } else {
            errorBox.textContent = data.message || 'เกิดข้อผิดพลาด กรุณาลองใหม่';
        }

        submitBtn.disabled = false;
        submitBtn.textContent = originalText;
    })
    .catch((err) => {
        console.error(err);
        errorBox.textContent = 'เกิดข้อผิดพลาดในการเชื่อมต่อ กรุณาลองใหม่';
        submitBtn.disabled = false;
        submitBtn.textContent = originalText;
    });
});

// เคลียร์ error message ทุกครั้งที่เปิด modal ใหม่
addCategoryModalEl.addEventListener('show.bs.modal', function () {
    document.getElementById('category_name_error').textContent = '';
});

// ------------------------------------------------------------------
// จัดการรูปภาพ: เพิ่ม/ลบ/จัดเรียง/ตั้งรูปหลัก
// ------------------------------------------------------------------
const modalImageInput = document.getElementById('modal-image-input');
const sortableList     = document.getElementById('sortable-images');
const addImageSlot     = document.getElementById('add-image-slot');

const deletedImageIds = new Set(); // image_id ของรูปเดิมที่ถูกลบ
const newFilesMap     = new Map(); // newId -> File object (รูปใหม่ที่เพิ่มเข้ามา)
let primaryImageId     = {{ isset($product) && $product->images ? ($product->images->firstWhere('is_primary', true)->image_id ?? 'null') : 'null' }};
let newIdCounter       = 0;

// 1) กดปุ่ม "+ เพิ่มรูป" ในโมดัล -> เปิดตัวเลือกไฟล์
addImageSlot.addEventListener('click', function () {
    modalImageInput.click();
});

// 2) เลือกไฟล์แล้ว -> แสดง preview ใน sortable list
modalImageInput.addEventListener('change', function (e) {
    Array.from(e.target.files).forEach(file => {
        const newId = 'new-' + (++newIdCounter);
        newFilesMap.set(newId, file);

        const reader = new FileReader();
        reader.onload = function (ev) {
            const item = document.createElement('div');
            item.className = 'col-auto image-manage-item';
            item.setAttribute('draggable', 'true');
            item.dataset.type = 'new';
            item.dataset.newId = newId;
            item.innerHTML = `
                <div class="position-relative border rounded p-1" style="width:100px;">
                    <span class="badge bg-dark position-absolute top-0 start-0 m-1 order-badge"></span>
                    <img src="${ev.target.result}" width="90" height="90" style="object-fit:cover;border-radius:6px;display:block;">
                </div>
                <div class="text-center mt-1">
                    <a href="#" class="text-danger small delete-image-item">ลบ</a>
                </div>
            `;
            sortableList.insertBefore(item, addImageSlot);
            refreshOrderBadges();
        };
        reader.readAsDataURL(file);
    });
    // เคลียร์ input เพื่อให้เลือกไฟล์เดิมซ้ำได้ในครั้งถัดไป
    modalImageInput.value = '';
});

// 3) ลบรูป (ทั้งของเดิมและของใหม่) + ตั้งรูปหลัก
sortableList.addEventListener('click', function (e) {
    if (e.target.classList.contains('delete-image-item')) {
        e.preventDefault();
        const item = e.target.closest('.image-manage-item');
        if (item.dataset.type === 'existing') {
            deletedImageIds.add(item.dataset.imageId);
            if (primaryImageId == item.dataset.imageId) primaryImageId = null;
        } else {
            newFilesMap.delete(item.dataset.newId);
        }
        item.remove();
        refreshOrderBadges();
    }

    if (e.target.classList.contains('set-primary-btn')) {
        const item = e.target.closest('.image-manage-item');
        if (item.dataset.type === 'existing') {
            primaryImageId = item.dataset.imageId;
            document.querySelectorAll('.set-primary-btn').forEach(el => el.textContent = '☆');
            e.target.textContent = '⭐';
        }
    }
});

// 4) ลากจัดเรียงลำดับ (แบบพื้นฐาน)
let dragSrcEl = null;
sortableList.addEventListener('dragstart', function (e) {
    const item = e.target.closest('.image-manage-item');
    if (!item) return;
    dragSrcEl = item;
    e.dataTransfer.effectAllowed = 'move';
});
sortableList.addEventListener('dragover', function (e) {
    e.preventDefault();
    const target = e.target.closest('.image-manage-item');
    if (!target || target === dragSrcEl || !dragSrcEl) return;
    const rect = target.getBoundingClientRect();
    const after = (e.clientX - rect.left) > rect.width / 2;
    sortableList.insertBefore(dragSrcEl, after ? target.nextSibling : target);
    refreshOrderBadges();
});
sortableList.addEventListener('dragend', function () {
    dragSrcEl = null;
});

function refreshOrderBadges() {
    let i = 1;
    sortableList.querySelectorAll('.image-manage-item').forEach(item => {
        const badge = item.querySelector('.order-badge');
        if (badge) badge.textContent = i++;
    });
}

// 5) กด "ตกลง" ในโมดัล -> อัปเดต preview หลักในฟอร์ม
document.getElementById('applyImageChanges').addEventListener('click', function () {
    const existingImagesBox = document.getElementById('existing-images');
    existingImagesBox.innerHTML = '';

    const items = sortableList.querySelectorAll('.image-manage-item');
    if (items.length === 0) {
        existingImagesBox.innerHTML = '<span class="text-muted small" id="no-images-msg">ยังไม่มีรูปภาพ</span>';
        return;
    }

    items.forEach(item => {
        const img = item.querySelector('img');
        const div = document.createElement('div');
        div.className = 'col-auto text-center';
        if (item.dataset.type === 'existing') div.dataset.imageId = item.dataset.imageId;
        div.innerHTML = `<img src="${img.src}" width="90" height="90" style="object-fit:cover;border-radius:8px;" class="border">`;
        existingImagesBox.appendChild(div);
    });
});

// ------------------------------------------------------------------
// 6) Submit ฟอร์มจริงแบบ AJAX (fetch) -> ป้องกันไม่ให้ full page reload
//    ทำลาย state ของรูปภาพที่จัดการไว้ในโมดัลเมื่อ validation ไม่ผ่าน
// ------------------------------------------------------------------
const productForm = document.getElementById('productForm');

productForm.addEventListener('submit', function (e) {
    e.preventDefault(); // ⭐ กัน browser POST แบบ full reload

    // เคลียร์ error เก่าทั้งหมดก่อนส่งรอบใหม่
    clearFormErrors(productForm);

    const hiddenBox = document.getElementById('image-hidden-inputs');
    hiddenBox.innerHTML = '';

    // delete_images[]
    deletedImageIds.forEach(id => {
        const input = document.createElement('input');
        input.type = 'hidden';
        input.name = 'delete_images[]';
        input.value = id;
        hiddenBox.appendChild(input);
    });

    // image_order[image_id] = ลำดับ (เฉพาะรูปเดิมที่ยังอยู่)
    let order = 0;
    sortableList.querySelectorAll('.image-manage-item[data-type="existing"]').forEach(item => {
        const input = document.createElement('input');
        input.type = 'hidden';
        input.name = `image_order[${item.dataset.imageId}]`;
        input.value = order++;
        hiddenBox.appendChild(input);
    });

    // primary_image_id
    if (primaryImageId) {
        const input = document.createElement('input');
        input.type = 'hidden';
        input.name = 'primary_image_id';
        input.value = primaryImageId;
        hiddenBox.appendChild(input);
    }

    // ใส่ไฟล์ใหม่ (ตามลำดับที่แสดงในโมดัล) เข้า main-images-input จริง
    const mainInput = document.getElementById('main-images-input');
    const dataTransfer = new DataTransfer();
    sortableList.querySelectorAll('.image-manage-item[data-type="new"]').forEach(item => {
        const file = newFilesMap.get(item.dataset.newId);
        if (file) dataTransfer.items.add(file);
    });
    mainInput.files = dataTransfer.files;

    // เก็บ FormData หลังจากเซ็ตทุกอย่างครบแล้ว
    const formData = new FormData(productForm);

    const submitBtn = productForm.querySelector('button[type="submit"]');
    const originalBtnText = submitBtn.textContent;
    submitBtn.disabled = true;
    submitBtn.textContent = 'กำลังบันทึก...';

    fetch(productForm.action, {
        method: 'POST',
        headers: {
            'X-Requested-With': 'XMLHttpRequest', // ทำให้ $request->ajax() เป็น true
            'Accept': 'application/json',
        },
        body: formData,
    })
    .then(async (res) => {
        let data = {};
        try {
            data = await res.json();
        } catch (_) {
            // ไม่ใช่ JSON (เช่น error 500 คืน HTML) ให้ถือว่าล้มเหลว
        }

        if (res.ok && data.success) {
            window.location.href = data.redirect || '/product';
            return;
        }

        if (res.status === 422 && data.errors) {
            showFormErrors(productForm, data.errors);
        } else if (data.message) {
            alert(data.message);
        } else {
            alert('เกิดข้อผิดพลาดในการบันทึกข้อมูล กรุณาลองใหม่อีกครั้ง');
        }

        submitBtn.disabled = false;
        submitBtn.textContent = originalBtnText;
    })
    .catch((err) => {
        console.error(err);
        alert('เกิดข้อผิดพลาดในการเชื่อมต่อ กรุณาลองใหม่');
        submitBtn.disabled = false;
        submitBtn.textContent = originalBtnText;
    });
});

// แสดง error message ใต้แต่ละ field โดยไม่ reload หน้า (state รูปภาพยังอยู่ครบ)
function showFormErrors(form, errors) {
    Object.keys(errors).forEach(field => {
        // field ที่เป็น array เช่น attribute_key.0 หรือ images.1 ให้ map ไปที่กล่องรวม
        const baseField = field.split('.')[0];

        if (baseField === 'images') {
            const box = document.getElementById('images-error');
            if (box) box.textContent = errors[field][0];
            return;
        }

        let input = form.querySelector(`[name="${baseField}"]`)
                 || form.querySelector(`[name="${baseField}[]"]`);
        if (!input) return;

        const errDiv = document.createElement('div');
        errDiv.className = 'text-danger small form-error-msg';
        errDiv.textContent = errors[field][0];

        const container = input.closest('.mb-3') || input.parentElement;
        container.appendChild(errDiv);
    });
}

function clearFormErrors(form) {
    form.querySelectorAll('.form-error-msg').forEach(el => el.remove());
    const imgErr = document.getElementById('images-error');
    if (imgErr) imgErr.textContent = '';
}
</script>
@endsection