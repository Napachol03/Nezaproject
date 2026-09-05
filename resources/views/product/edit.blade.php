@extends('home')

@section('css_before')
@endsection

@section('header')
@endsection

@section('sidebarMenu')
@endsection

@section('content')
<div class="form-card">
    <h3>ฟอร์มแก้ไขสินค้า</h3>

<form action="/product/{{ $product->product_id }}" method="post" enctype="multipart/form-data" id="product-form">
@csrf
@method('put')

<div class="mb-3">
    <label>ชื่อสินค้า</label>
    <input type="text" class="form-control" name="product_name" required placeholder="ชื่อสินค้า" minlength="3" value="{{ old('product_name', $product->product_name) }}">
    @if($errors->has('product_name'))
        <div class="text-danger small"> {{ $errors->first('product_name') }}</div>
    @endif
</div>

<div class="mb-3">
    <label>รายละเอียด</label>
<<<<<<< HEAD
    <textarea class="form-control" name="description" rows="10" placeholder="รายละเอียดสินค้า">{{ old('description', $product->description) }}</textarea>
=======
    <textarea class="form-control" name="description" rows="3" placeholder="รายละเอียดสินค้า">{{ old('description', $product->description) }}</textarea>
>>>>>>> 19bea7484cccea031972b54bada982e94bcc8b3c
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
            <!-- เพิ่ม data-bs-toggle และ data-bs-target เพื่อสั่งเปิด Modal โดยตรง -->
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
        <input type="checkbox" class="form-check-input" name="is_featured" id="is_featured" value="1" {{ old('is_featured', $product->is_featured) ? 'checked' : '' }}>
        <label class="form-check-label" for="is_featured">สินค้าเด่น (Featured)</label>
    </div>
    <div class="form-check">
        <input type="checkbox" class="form-check-input" name="is_active" id="is_active" value="1" {{ old('is_active', $product->is_active) ? 'checked' : '' }}>
        <label class="form-check-label" for="is_active">แสดงบนเว็บ (Active)</label>
    </div>
</div>

<div class="mb-3">
    <label>สเปกสินค้า</label>
    <div id="attribute-rows">
        @forelse(($product->attributes ?? []) as $key => $value)
            <div class="row mb-2 attribute-row g-2">
                <div class="col-5">
                    <input type="text" class="form-control" name="attribute_key[]" value="{{ $key }}" placeholder="เช่น สี, ไซส์" list="attribute-key-list">
                </div>
                <div class="col-5">
                    <input type="text" class="form-control" name="attribute_value[]" value="{{ $value }}" placeholder="เช่น ดำ, M" list="attribute-value-list">
                </div>
                <div class="col-2">
                    <button type="button" class="btn btn-outline-danger remove-row-btn remove-row">ลบ</button>
                </div>
            </div>
        @empty
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
        @endforelse
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
    <!-- หัวข้อพร้อมปุ่มแก้ไข -->
    <div class="d-flex justify-content-between align-items-center mb-2">
        <label class="form-label fw-bold m-0">จัดการรูปภาพ</label>
        <button type="button" class="btn btn-link text-danger p-0 text-decoration-none" data-bs-toggle="modal" data-bs-target="#manageImageModal">
            แก้ไข
        </button>
    </div>

    <!-- แสดงตัวอย่างรูปภาพเดิม -->
    <div class="row g-2" id="existing-images">
        @forelse($product->images->sortBy('sort_order') as $img)
            <div class="col-auto text-center" data-image-id="{{ $img->image_id }}">
                <img src="{{ $img->image_url }}" width="90" height="90" style="object-fit: cover; border-radius: 8px;" class="border">
            </div>
        @empty
            <span class="text-muted small" id="no-images-msg">ยังไม่มีรูปภาพ</span>
        @endforelse
    </div>

    <!-- hidden inputs ที่ส่งกลับไปให้ Controller -->
    <div id="image-hidden-inputs"></div>
</div>

<div class="mb-3">
    <input type="file" class="form-control" name="images[]" id="main-images-input" multiple accept="image/*" hidden>
    <small class="text-muted">เพิ่ม/จัดเรียง/ลบรูปภาพได้ผ่านปุ่ม "แก้ไข" ด้านบน</small>
</div>

<div class="d-flex gap-2 mt-2 justify-content-end">
    <button type="submit" class="btn btn-submit-gradient">บันทึกข้อมูล</button>
    <a href="/product" class="btn btn-cancel-gradient text-center">ยกเลิก</a>
</div>
</form>
</div>

<!-- Modal เพิ่มหมวดหมู่ -->
<<<<<<< HEAD
<!-- แก้ไข: เดิม force เปิดด้วย class="show" + style="display:block" ตรงๆ
     ทำให้ Bootstrap ไม่มี instance ผูกกับ modal นี้ (ไม่มี backdrop, ไม่ track state)
     กดปุ่ม data-bs-dismiss="modal" (ยกเลิก) จึงไม่ทำงาน
     แก้โดยเอา force-show ออก แล้วเปิดผ่าน bootstrap.Modal จริงๆ ด้วย JS ด้านล่างแทน -->
<div class="modal fade" id="addCategoryModal" tabindex="-1">
=======
<div class="modal fade @if($errors->hasBag('category')) show @endif" id="addCategoryModal" tabindex="-1" @if($errors->hasBag('category')) style="display:block" @endif>
>>>>>>> 19bea7484cccea031972b54bada982e94bcc8b3c
  <div class="modal-dialog">
    <div class="modal-content">
      <form action="/category" method="post">
        @csrf
        <div class="modal-header">
          <h5 class="modal-title">เพิ่มหมวดหมู่ใหม่</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
        </div>
        <div class="modal-body">
            <div class="mb-3">
                <label>ชื่อหมวดหมู่</label>
<<<<<<< HEAD
                <input type="text" class="form-control" name="category_name" required minlength="2"
                       placeholder="เช่น เสื้อ, ร่ม, กระเป๋า"
                       value="{{ old('category_name') }}">
=======
                <input type="text" class="form-control" name="category_name" required minlength="2" placeholder="เช่น เสื้อ, ร่ม, กระเป๋า">
>>>>>>> 19bea7484cccea031972b54bada982e94bcc8b3c
                @if($errors->hasBag('category') && $errors->getBag('category')->has('category_name'))
                    <div class="text-danger small">{{ $errors->getBag('category')->first('category_name') }}</div>
                @endif
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

<!-- Modal จัดการรูปภาพ -->
<div class="modal fade" id="manageImageModal" tabindex="-1">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">จัดการรูปภาพ</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
      </div>
      <div class="modal-body">
        <p class="text-muted small mb-2">ลากรูปเพื่อจัดเรียงลำดับ คลิก "ลบ" เพื่อลบรูป หรือกด "+ เพิ่มรูป" เพื่อเพิ่มรูปใหม่</p>

        <div class="row g-3" id="sortable-images">
            @foreach($product->images->sortBy('sort_order') as $img)
            <div class="col-auto image-manage-item" draggable="true" data-type="existing" data-image-id="{{ $img->image_id }}">
                <div class="position-relative border rounded p-1" style="width:100px;">
                    <span class="badge bg-dark position-absolute top-0 start-0 m-1 order-badge">{{ $loop->iteration }}</span>
                    <img src="{{ $img->image_url }}" width="90" height="90" style="object-fit:cover;border-radius:6px;display:block;">
                </div>
                <div class="text-center mt-1">
                    <a href="#" class="text-danger small delete-image-item">ลบ</a>
                </div>
            </div>
            @endforeach

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

<<<<<<< HEAD
=======
{{-- แก้ไข: เดิมมี @section('js_before') ประกาศซ้ำอีก 2 ครั้งด้านล่าง (ว่างเปล่า)
     ซึ่งจะเขียนทับ script ก้อนนี้ทั้งหมดจนกลายเป็นค่าว่าง ทำให้ JS ทุกอย่างในหน้านี้
     ไม่ทำงานเลย (ปุ่มเพิ่ม attribute, เปิด modal หมวดหมู่, จัดการรูปภาพ) ได้ลบสอง
     section ที่ซ้ำซ้อนออกแล้ว เหลือ section เดียวด้านล่างนี้เท่านั้น

     นอกจากนี้ ส่วนจัดการรูปภาพเดิมยังขาดหลายจุด:
       - ไม่ได้ประกาศตัวแปร addImageSlot, newFiles, deletedExistingIds
       - ไม่มีฟังก์ชัน renumber() / attachDragEvents() ที่ถูกเรียกใช้จริง
       - ไม่มีการลาก-วางเพื่อจัดเรียงลำดับ (drag & drop)
       - ไม่มีการสร้าง hidden input (image_order[], delete_images[], primary_image_id)
         ที่ Controller (update()) คาดหวังไว้ตอน submit ฟอร์ม
       - รูปใหม่ที่เพิ่มใน modal ไม่เคยถูกผูกเข้ากับ input จริงที่ชื่อ images[]
         (#main-images-input) จึงไม่ถูกส่งไปกับฟอร์มเลย
     ทั้งหมดนี้ถูกเติมให้ครบด้านล่าง --}}
>>>>>>> 19bea7484cccea031972b54bada982e94bcc8b3c
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

/* =========================================================
   จัดการรูปภาพ (Modal #manageImageModal)
   ========================================================= */
const sortableList   = document.getElementById('sortable-images');
const addImageSlot   = document.getElementById('add-image-slot');
const modalImageInput = document.getElementById('modal-image-input');

let newFiles = [];            // เก็บ File object ของรูปใหม่ที่เพิ่งเพิ่ม (index อ้างอิงด้วย data-file-index)
let deletedExistingIds = [];  // เก็บ image_id ของรูปเดิมที่ถูกลบ
let draggedItem = null;

/* เรียงเลขลำดับ (badge) ใหม่ตามตำแหน่งปัจจุบันใน DOM */
function renumber() {
    const items = sortableList.querySelectorAll('.image-manage-item');
    items.forEach((item, idx) => {
        const badge = item.querySelector('.order-badge');
        if (badge) badge.textContent = idx + 1;
    });
}

/* ผูก event ลาก-วาง ให้แต่ละ item (ทั้งรูปเดิมตอนโหลดหน้าแรก และรูปใหม่ที่เพิ่มภายหลัง) */
function attachDragEvents(item) {
    item.addEventListener('dragstart', function () {
        draggedItem = item;
        item.classList.add('opacity-50');
    });

    item.addEventListener('dragend', function () {
        item.classList.remove('opacity-50');
        draggedItem = null;
        renumber();
    });

    item.addEventListener('dragover', function (e) {
        e.preventDefault();
        if (!draggedItem || draggedItem === item) return;
        const rect = item.getBoundingClientRect();
        const isAfter = (e.clientX - rect.left) > (rect.width / 2);
        sortableList.insertBefore(draggedItem, isAfter ? item.nextSibling : item);
    });
}

/* ผูก drag event ให้รูปเดิมที่มีอยู่แล้วตอนโหลดหน้า */
sortableList.querySelectorAll('.image-manage-item').forEach(attachDragEvents);

/* ---- เพิ่มรูปใหม่ ---- */
addImageSlot.addEventListener('click', function () {
    modalImageInput.click();
});

modalImageInput.addEventListener('change', function () {
    Array.from(this.files).forEach(file => {
        const fileIndex = newFiles.length;
        newFiles.push(file);

        const reader = new FileReader();
        reader.onload = function (e) {
            const item = document.createElement('div');
            item.className = 'col-auto image-manage-item';
            item.draggable = true;
            item.dataset.type = 'new';
            item.dataset.fileIndex = fileIndex;
            item.innerHTML = `
                <div class="position-relative border rounded p-1" style="width:100px;">
                    <span class="badge bg-dark position-absolute top-0 start-0 m-1 order-badge"></span>
                    <img src="${e.target.result}" width="90" height="90" style="object-fit:cover;border-radius:6px;display:block;">
                </div>
                <div class="text-center mt-1">
                    <a href="#" class="text-danger small delete-image-item">ลบ</a>
                </div>`;
            sortableList.insertBefore(item, addImageSlot);
            attachDragEvents(item);
            renumber();
        };
        reader.readAsDataURL(file);
    });
    modalImageInput.value = '';
});

/* ---- ลบรูป (ทั้งรูปเดิมและรูปใหม่ที่เพิ่งเพิ่ม) ---- */
sortableList.addEventListener('click', function (e) {
    if (!e.target.classList.contains('delete-image-item')) return;
    e.preventDefault();
    const item = e.target.closest('.image-manage-item');
    if (item.dataset.type === 'existing') {
        deletedExistingIds.push(item.dataset.imageId);
    } else if (item.dataset.type === 'new') {
        item.dataset.removed = '1';
    }
    item.remove();
    renumber();
});

/* ---- กด "ตกลง" ในโมดัล: สรุปผลลัพธ์ทั้งหมดเป็น hidden input ให้ฟอร์มหลักส่งไปกับ submit ---- */
document.getElementById('applyImageChanges').addEventListener('click', function () {
    const items = Array.from(sortableList.querySelectorAll('.image-manage-item'));

    const hiddenWrap = document.getElementById('image-hidden-inputs');
    hiddenWrap.innerHTML = '';

    let order = 0;
    let firstExistingId = null;
    const dt = new DataTransfer(); // ใช้รวมไฟล์รูปใหม่ตามลำดับล่าสุด แล้วผูกเข้ากับ input จริง

    items.forEach(item => {
        if (item.dataset.type === 'existing') {
            const imgId = item.dataset.imageId;
            if (firstExistingId === null) firstExistingId = imgId;

            const input = document.createElement('input');
            input.type = 'hidden';
            input.name = `image_order[${imgId}]`;
            input.value = order;
            hiddenWrap.appendChild(input);
            order++;
        } else if (item.dataset.type === 'new' && !item.dataset.removed) {
            const fileIndex = parseInt(item.dataset.fileIndex, 10);
            if (newFiles[fileIndex]) {
                dt.items.add(newFiles[fileIndex]);
            }
            order++;
        }
    });

    // รูปเดิมที่ถูกลบ
    deletedExistingIds.forEach(id => {
        const input = document.createElement('input');
        input.type = 'hidden';
        input.name = 'delete_images[]';
        input.value = id;
        hiddenWrap.appendChild(input);
    });

    // ตั้งรูปหลัก = รูปเดิมตัวแรกตามลำดับใหม่ (ถ้ามีรูปเดิมเหลืออยู่)
    if (firstExistingId !== null) {
        const primaryInput = document.createElement('input');
        primaryInput.type = 'hidden';
        primaryInput.name = 'primary_image_id';
        primaryInput.value = firstExistingId;
        hiddenWrap.appendChild(primaryInput);
    }

    // ผูกไฟล์รูปใหม่เข้ากับ input จริงของฟอร์ม (name="images[]")
    const mainInput = document.getElementById('main-images-input');
    mainInput.files = dt.files;

    // อัปเดตพรีวิวด้านนอก modal ให้ตรงกับสถานะล่าสุด
    const previewWrap = document.getElementById('existing-images');
    previewWrap.innerHTML = '';
    let hasAny = false;

    items.forEach(item => {
        const img = item.querySelector('img');
        if (item.dataset.type === 'existing') {
            hasAny = true;
            const col = document.createElement('div');
            col.className = 'col-auto text-center';
            col.dataset.imageId = item.dataset.imageId;
            col.innerHTML = `<img src="${img.src}" width="90" height="90" style="object-fit:cover;border-radius:8px;" class="border">`;
            previewWrap.appendChild(col);
        } else if (item.dataset.type === 'new' && !item.dataset.removed) {
            hasAny = true;
            const col = document.createElement('div');
            col.className = 'col-auto text-center';
            col.innerHTML = `<img src="${img.src}" width="90" height="90" style="object-fit:cover;border-radius:8px;" class="border">`;
            previewWrap.appendChild(col);
        }
    });

    if (!hasAny) {
        previewWrap.innerHTML = '<span class="text-muted small" id="no-images-msg">ยังไม่มีรูปภาพ</span>';
    }
});
<<<<<<< HEAD

/* ---- เปิด modal เพิ่มหมวดหมู่อัตโนมัติ เมื่อมี validation error จากการเพิ่มหมวดหมู่ ----
   เดิมใช้วิธี force class="show" + style="display:block" ใน HTML ตรงๆ
   ซึ่งทำให้ Bootstrap ไม่มี instance ผูกกับ modal (ไม่มี backdrop, ไม่ track state)
   ปุ่มยกเลิก (data-bs-dismiss) จึงกดไม่ออก
   แก้โดยเปิดผ่าน bootstrap.Modal จริง ๆ แทน */
@if($errors->hasBag('category'))
document.addEventListener('DOMContentLoaded', function () {
    bootstrap.Modal.getOrCreateInstance(
        document.getElementById('addCategoryModal')
    ).show();
});
@endif
=======
>>>>>>> 19bea7484cccea031972b54bada982e94bcc8b3c
</script>
@endsection

@section('footer')
@endsection