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
                    <i class="fas fa-file-invoice me-2"></i>
                    ใบเสนอราคา
                </h4>

                <a href="/quotation/adding" class="btn btn-light btn-sm">
                    <i class="fas fa-plus me-1"></i>
                    สร้างใบเสนอราคา
                </a>
            </div>

            <div class="card-body">

                <div class="d-flex align-items-center justify-content-between gap-2 mb-3 flex-wrap">

                    <div class="d-flex align-items-center gap-2 flex-wrap">

                        <!-- ทั้งหมด -->
                        <a href="{{ url('/quotation') }}"
                            class="category-btn text-decoration-none {{ !request('status') ? 'active' : '' }}">
                            ทั้งหมด
                        </a>

                        @foreach (['draft' => 'ฉบับร่าง', 'sent' => 'ส่งแล้ว', 'approved' => 'อนุมัติแล้ว', 'rejected' => 'ไม่อนุมัติ'] as $statusKey => $statusLabel)
                            <a href="{{ url('/quotation?status=' . $statusKey) }}"
                                class="category-btn text-decoration-none {{ request('status') == $statusKey ? 'active' : '' }}">
                                {{ $statusLabel }}
                            </a>
                        @endforeach

                    </div>

                    <form action="{{ url('/quotation') }}" method="GET" class="d-flex gap-2">
                        @if (request('status'))
                            <input type="hidden" name="status" value="{{ request('status') }}">
                        @endif
                        <input type="text" name="keyword" value="{{ request('keyword') }}"
                            class="form-control form-control-sm" placeholder="ค้นหาเลขที่ / ชื่อลูกค้า"
                            style="min-width:220px;">
                        <button type="submit" class="btn btn-outline-secondary btn-sm">
                            <i class="fas fa-search"></i>
                        </button>
                    </form>

                </div>

                <div class="table-responsive">

                    <table class="table table-hover align-middle">

                        <thead class="table-light text-center">
                            <tr>
                                <th width="5%">#</th>
                                <th width="12%">เลขที่</th>
                                <th>ลูกค้า / หน่วยงาน</th>
                                <th width="12%">วันที่</th>
                                <th width="14%">ยอดรวม</th>
                                <th width="12%">สถานะ</th>
                                <th width="17%">Action</th>
                            </tr>
                        </thead>

                        <tbody>

                            @forelse ($quotations as $row)
                                <tr>

                                    <td class="text-center">
                                        {{ $loop->iteration }}
                                    </td>

                                    <td class="text-center fw-bold">
                                        {{ $row->quotation_no }}
                                    </td>

                                    <td class="text-center">
                                        {{ $row->customer->customer_name ?? '-' }}
                                    </td>

                                    <td class="text-center">
                                        {{ $row->quotation_date ? \Carbon\Carbon::parse($row->quotation_date)->format('d/m/Y') : '-' }}
                                    </td>

                                    <td class="text-end">
                                        {{ number_format($row->total_amount, 2) }}
                                    </td>

                                    <td class="text-center">
                                        @php
                                            $statusMap = [
                                                'draft'    => ['label' => 'ฉบับร่าง',   'class' => 'bg-secondary'],
                                                'sent'     => ['label' => 'ส่งแล้ว',    'class' => 'bg-info'],
                                                'approved' => ['label' => 'อนุมัติแล้ว', 'class' => 'bg-success'],
                                                'rejected' => ['label' => 'ไม่อนุมัติ',  'class' => 'bg-danger'],
                                            ];
                                            $statusInfo = $statusMap[$row->status] ?? ['label' => $row->status, 'class' => 'bg-secondary'];
                                        @endphp
                                        <span class="badge {{ $statusInfo['class'] }}">
                                            {{ $statusInfo['label'] }}
                                        </span>
                                    </td>

                                    <td class="text-center">

                                        <a href="/quotation/{{ $row->quotation_id }}/print"
                                            class="btn btn-outline-primary btn-sm action-btn" title="พิมพ์" target="_blank">
                                            <i class="fas fa-print"></i>
                                        </a>

                                        <a href="/quotation/{{ $row->quotation_id }}"
                                            class="btn btn-outline-warning btn-sm action-btn" title="แก้ไข">
                                            <i class="fas fa-pen"></i>
                                        </a>

                                        <button type="button" class="btn btn-outline-danger btn-sm action-btn"
                                            onclick="deleteConfirm({{ $row->quotation_id }})" title="ลบ">
                                            <i class="fas fa-trash"></i>
                                        </button>

                                        <form id="delete-form-{{ $row->quotation_id }}"
                                            action="/quotation/remove/{{ $row->quotation_id }}" method="POST"
                                            style="display:none">
                                            @csrf
                                            @method('delete')
                                        </form>

                                    </td>

                                </tr>
                            @empty
                                <tr>
                                    <td colspan="7" class="text-center text-muted py-4">
                                        ยังไม่มีใบเสนอราคา
                                    </td>
                                </tr>
                            @endforelse

                        </tbody>

                    </table>

                </div>

                <div class="mt-3">
                    {{ $quotations->links() }}
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