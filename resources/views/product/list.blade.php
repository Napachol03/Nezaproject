@extends('home')

@section('css_before')
@endsection

@section('header')
@endsection

@section('sidebarMenu')
@endsection

@section('content')
    <div class="container-fluid mt-4">

        <div class="card shadow border-0">

            <div class="card-header text-white d-flex justify-content-between align-items-center">
                <h4 class="mb-0">
                    <i class="fas fa-box me-2"></i>
                    สินค้า
                </h4>

                <a href="/product/adding" class="btn btn-light btn-sm">
                    <i class="fas fa-plus me-1"></i>
                    เพิ่มสินค้า
                </a>
            </div>

            <div class="card-body">

                <div class="d-flex align-items-center gap-2 mb-3 flex-wrap">

                    <!-- ทั้งหมด -->
                    <a href="{{ url('/product') }}"
                        class="category-btn text-decoration-none {{ !request('category_id') ? 'active' : '' }}">
                        ทั้งหมด
                    </a>

                    @foreach ($categories as $category)
                        <a href="{{ url('/product?category_id=' . $category->category_id) }}"
                            class="category-btn text-decoration-none {{ request('category_id') == $category->category_id ? 'active' : '' }}">
                            {{ $category->category_name }}
                        </a>
                    @endforeach

                </div>

                <div class="table-responsive">

                    <table class="table table-hover align-middle">

                        <thead class="table-light text-center">
                            <tr>
                                <th width="5%">#</th>
                                <th width="10%">Image</th>
                                <th>ข้อมูลสินค้า</th>
                                <th width="12%">Featured</th>
                                <th width="12%">Active</th>
                                <th width="18%">Action</th>
                            </tr>
                        </thead>

                        <tbody>

                            @foreach ($productList as $row)
                                <tr>

                                    <td class="text-center">
                                        {{ $loop->iteration }}
                                    </td>

                                    <td class="text-center">

                                        @if ($row->images->first())
                                            <img src="{{ $row->images->first()->image_url }}" alt="{{ $row->product_name }}"
                                                width="70" height="70" style="object-fit:cover;">
                                        @else
                                            <img src="{{ asset('images/no-image.png') }}" alt="No Image"
                                                class="rounded-circle border" width="70" height="70">
                                        @endif

                                    </td>

                                    <td>

                                        <h6 class="mb-1 fw-bold">
                                            {{ $row->product_name }}
                                        </h6>

                                        <div>
                                            <strong>Category :</strong>
                                            {{ $row->category->category_name ?? '-' }}
                                        </div>

                                    </td>

                                    <td align="center">
                                        <button type="button"
                                            class="btn btn-sm toggle-featured-btn {{ $row->is_featured ? 'btn-success' : 'btn-secondary' }}"
                                            data-id="{{ $row->product_id }}">
                                            {{ $row->is_featured ? 'เด่น' : '-' }}
                                        </button>
                                    </td>

                                    <td align="center">
                                        <button type="button"
                                            class="btn btn-sm toggle-active-btn {{ $row->is_active ? 'btn-success' : 'btn-danger' }}"
                                            data-id="{{ $row->product_id }}">
                                            {{ $row->is_active ? 'แสดง' : '-' }}
                                        </button>
                                    </td>

                                    <td class="text-center">

                                        <a href="/product/{{ $row->product_id }}"
                                            class="btn btn-outline-warning btn-sm action-btn" title="แก้ไข">
                                            <i class="fas fa-pen"></i>
                                        </a>

                                        <button type="button" class="btn btn-outline-danger btn-sm action-btn"
                                            onclick="deleteConfirm({{ $row->product_id }})" title="ลบ">
                                            <i class="fas fa-trash"></i>
                                        </button>

                                        <form id="delete-form-{{ $row->product_id }}"
                                            action="/product/remove/{{ $row->product_id }}" method="POST"
                                            style="display:none">
                                            @csrf
                                            @method('delete')
                                        </form>

                                    </td>

                                </tr>
                            @endforeach

                        </tbody>

                    </table>

                </div>

                <div class="mt-3">
                    {{ $productList->links() }}
                </div>

            </div>

        </div>

    </div>
@endsection

@section('footer')
@endsection

{{-- แก้ไข: เดิม @section('js_before') ถูกประกาศซ้ำ 3 ครั้ง (2 ครั้งหลังว่างเปล่า)
     ทำให้ Blade เขียนทับ script ทั้งก้อนด้านล่างนี้จนหายไป และมี PHP method
     (toggleFeatured / toggleActive) หลุดเข้าไปอยู่ใน <script> ทำให้ JS ทั้งไฟล์พัง
     ทั้งสองจุดถูกลบ/ย้ายออกแล้ว เหลือ section เดียวด้านล่างนี้ --}}
@section('js_before')
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script>
        function deleteConfirm(id) {
            Swal.fire({
                title: 'คุณแน่ใจหรือไม่?',
                text: 'หากลบแล้วจะไม่สามารถกู้คืนได้!',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#3085d6',
                confirmButtonText: 'ใช่, ลบเลย!',
                cancelButtonText: 'ยกเลิก'
            }).then((result) => {
                if (result.isConfirmed) {
                    document.getElementById('delete-form-' + id).submit();
                }
            });
        }

        $(document).on('change', '.toggle-featured', function() {

            let id = $(this).data('id');
            let status = $(this).is(':checked') ? 1 : 0;

            $.ajax({
                url: '/product/' + id + '/toggle-featured',
                type: 'POST',
                data: {
                    _token: $('meta[name="csrf-token"]').attr('content'),
                    is_featured: status
                }
            });

        });

        $(document).on('change', '.toggle-active', function() {

            let id = $(this).data('id');
            let status = $(this).is(':checked') ? 1 : 0;

            $.ajax({
                url: '/product/' + id + '/toggle-active',
                type: 'POST',
                data: {
                    _token: $('meta[name="csrf-token"]').attr('content'),
                    is_active: status
                }
            });

        });
    </script>
@endsection
