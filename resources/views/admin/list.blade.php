@extends('home')

@section('content')

<div class="container-fluid mt-4">

    <div class="card shadow border-0">

        <div class="card-header text-white d-flex justify-content-between align-items-center">
            <h4 class="mb-0">
                <i class="fas fa-user-shield me-2"></i>
                Admin Management
            </h4>

            <a href="/admin/adding" class="btn btn-light btn-sm">
                <i class="fas fa-plus me-1"></i>
                เพิ่มผู้ดูแลระบบ
            </a>
        </div>

        <div class="card-body">

            <div class="table-responsive">

                <table class="table table-hover align-middle">

                    <thead class="table-light text-center">
                        <tr>
                            <th width="5%">#</th>
                            <th width="10%">Avatar</th>
                            <th>ข้อมูลผู้ใช้</th>
                            <th width="12%">Role</th>
                            <th width="10%">Status</th>
                            <th width="18%">Action</th>
                        </tr>
                    </thead>

                    <tbody>

                    @foreach($AdminList as $row)

                    <tr>

                        <td class="text-center">
                            {{ $loop->iteration }}
                        </td>

                        <td class="text-center">

                            @if($row->avatar_url)

                                <img src="{{ asset('storage/'.$row->avatar_url) }}"
                                     class="rounded-circle border"
                                     width="70"
                                     height="70"
                                     style="object-fit:cover;">

                            @else

                                <img src="{{ asset('images/no-avatar.png') }}"
                                     class="rounded-circle border"
                                     width="70"
                                     height="70">

                            @endif

                        </td>

                        <td>

                            <h6 class="mb-1 fw-bold">
                                {{ $row->full_name }}
                            </h6>

                            <div>
<<<<<<< HEAD
=======
                                <strong>User :</strong>
>>>>>>> 19bea7484cccea031972b54bada982e94bcc8b3c
                                {{ $row->username }}
                            </div>

                            <div>
<<<<<<< HEAD
=======
                                <strong>Email :</strong>
>>>>>>> 19bea7484cccea031972b54bada982e94bcc8b3c
                                {{ $row->email }}
                            </div>

                            <div>
<<<<<<< HEAD
=======
                                <strong>Phone :</strong>
>>>>>>> 19bea7484cccea031972b54bada982e94bcc8b3c
                                {{ $row->phone }}
                            </div>

                        </td>

                        <td class="text-center">

                            @if($row->role == "Super Admin")
                                <span class="badge bg-danger">{{ $row->role }}</span>
                            @elseif($row->role == "Admin")
                                <span class="badge bg-primary">{{ $row->role }}</span>
                            @else
                                <span class="badge bg-secondary">{{ $row->role }}</span>
                            @endif

                        </td>

                        <td class="text-center">

                            @if($row->status == "Active")
                                <span class="badge bg-success">Active</span>
                            @else
                                <span class="badge bg-danger">Inactive</span>
                            @endif

                        </td>

                        <td class="text-center">

                            <a href="/admin/{{ $row->id }}"
                               class="btn btn-outline-warning btn-sm action-btn"
                               title="แก้ไข">
                                <i class="fas fa-pen"></i>
                            </a>

                            <a href="/admin/reset/{{ $row->id }}"
                               class="btn btn-outline-info btn-sm action-btn"
                               title="รีเซ็ตรหัสผ่าน">
                                <i class="fas fa-key"></i>
                            </a>

                            <button type="button"
                                    class="btn btn-outline-danger btn-sm action-btn"
                                    onclick="deleteConfirm({{ $row->id }})"
                                    title="ลบ">
                                <i class="fas fa-trash"></i>
                            </button>

                            <form id="delete-form-{{ $row->id }}"
                                  action="/admin/remove/{{ $row->id }}"
                                  method="POST"
                                  style="display:none">
                                @csrf
                                @method('DELETE')
                            </form>

                        </td>

                    </tr>

                    @endforeach

                    </tbody>

                </table>

            </div>

            <div class="mt-3">
                {{ $AdminList->links() }}
            </div>

        </div>

    </div>

</div>

@endsection

@section('footer')
@endsection

@section('js_before')
@endsection

@section('js_before')
@endsection

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