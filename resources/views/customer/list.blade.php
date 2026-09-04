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
                    <i class="fas fa-users me-2"></i>
                    ลูกค้า
                </h4>

                <a href="/customer/adding" class="btn btn-light btn-sm">
                    <i class="fas fa-plus me-1"></i>
                    เพิ่มลูกค้า
                </a>
            </div>

            <div class="card-body">

                <div class="table-responsive">

                    <table class="table table-hover align-middle">

                        <thead class="table-light text-center">
                            <tr>
                                <th width="5%">#</th>
                                <th>ข้อมูลลูกค้า</th>
                                <th width="15%">เบอร์โทร</th>
                                <th width="18%">Action</th>
                            </tr>
                        </thead>

                        <tbody>

                            @foreach ($customerList as $row)
                                <tr>

                                    <td class="text-center">
                                        {{ $loop->iteration }}
                                    </td>

                                    <td>

                                        <h6 class="mb-1 fw-bold">
                                            {{ $row->customer_name }}
                                        </h6>

                                        <div>
                                            <strong>ที่อยู่ :</strong>
                                            {{ $row->address ?? '-' }}
                                        </div>

                                    </td>

                                    <td class="text-center">
                                        {{ $row->tel ?? '-' }}
                                    </td>

                                    <td class="text-center">

                                        <a href="/customer/{{ $row->customer_id }}"
                                            class="btn btn-outline-warning btn-sm action-btn" title="แก้ไข">
                                            <i class="fas fa-pen"></i>
                                        </a>

                                        <button type="button" class="btn btn-outline-danger btn-sm action-btn"
                                            onclick="deleteConfirm({{ $row->customer_id }})" title="ลบ">
                                            <i class="fas fa-trash"></i>
                                        </button>

                                        <form id="delete-form-{{ $row->customer_id }}"
                                            action="/customer/remove/{{ $row->customer_id }}" method="POST"
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
                    {{ $customerList->links() }}
                </div>

            </div>

        </div>

    </div>
@endsection

@section('footer')
@endsection

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
    </script>
@endsection