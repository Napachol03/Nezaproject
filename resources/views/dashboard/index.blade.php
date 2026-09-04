@extends('home')

@section('css_before')
@endsection

@section('header')
@endsection

@section('sidebarMenu')
@endsection

@section('content')
<div class="container-fluid py-4">

    <h1 class="h3 mb-4">Dashboard ยอดเข้าชมเว็ปไซต์</h1>

    {{-- ===== การ์ดสรุป ===== --}}
    <div class="row g-3 mb-4">
        
        <div class="col-md-4">
            <div class="card shadow-sm h-100">
                <div class="card-body">
                    <div class="text-muted small">ยอดวิวทั้งหมด</div>
                    <div class="h3 mb-0">{{ number_format($totalViews) }}</div>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card shadow-sm h-100">
                <div class="card-body">
                    <div class="text-muted small">ยอดวิววันนี้</div>
                    <div class="h3 mb-0">{{ number_format($todayViews) }}</div>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card shadow-sm h-100">
                <div class="card-body">
                    <div class="text-muted small">สินค้าที่มีคนเข้าชม</div>
                    <div class="h3 mb-0">{{ number_format($activeProducts) }}</div>
                </div>
            </div>
        </div>
    </div>

    {{-- ===== กราฟยอดวิวรายวัน ===== --}}
    <div class="card shadow-sm mb-4">
        <div class="card-header bg-white">
            <strong>ยอดวิวรายวัน (30 วันล่าสุด)</strong>
        </div>
        <div class="card-body">
            <canvas id="dailyViewsChart" height="90"></canvas>
        </div>
    </div>

    {{-- ===== ตารางสินค้าที่มีคนดูเยอะสุด ===== --}}
    <div class="card shadow-sm">
        <div class="card-header bg-white">
            <strong>สินค้าที่มีคนเข้าชมมากที่สุด</strong>
        </div>
        <div class="card-body p-0">
            <table class="table table-hover mb-0 align-middle">
                <thead class="table-light">
                    <tr>
                        <th style="width: 60px;">#</th>
                        <th>สินค้า</th>
                        <th class="text-end" style="width: 140px;">จำนวนวิว</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($topProducts as $index => $row)
                        <tr>
                            <td>{{ $index + 1 }}</td>
                            <td>
                                {{ $row->product->product_name ?? 'สินค้า #' . $row->product_id }}
                            </td>
                            <td class="text-end">{{ number_format($row->views_count) }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="3" class="text-center text-muted py-4">ยังไม่มีข้อมูลการเข้าชม</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

</div>
@endsection

@section('footer')
@endsection

@section('js_before')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    const ctx = document.getElementById('dailyViewsChart');

    new Chart(ctx, {
        type: 'line',
        data: {
            labels: @json($chartLabels),
            datasets: [{
                label: 'ยอดวิว',
                data: @json($chartData),
                borderColor: '#4e73df',
                backgroundColor: 'rgba(78, 115, 223, 0.1)',
                fill: true,
                tension: 0.3,
                pointRadius: 1,
            }]
        },
        options: {
            responsive: true,
            plugins: {
                legend: { display: false }
            },
            scales: {
                y: {
                    beginAtZero: true,
                    ticks: { precision: 0 }
                }
            }
        }
    });
</script>
@endsection