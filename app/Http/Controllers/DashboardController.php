<?php

namespace App\Http\Controllers;

use App\Models\ViewModel;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class DashboardController extends Controller
{

    public function __construct()
    {
        // ใช้ middleware 'auth:admin' เพื่อบังคับให้ต้องล็อกอินในฐานะ admin ก่อนใช้งาน controller นี้
        // ถ้าไม่ล็อกอินหรือไม่ได้ใช้ guard 'admin' จะถูก redirect ไปหน้า login
        $this->middleware('auth:admin');
    }

    public function index()
    {
        try {
            $totalViews     = ViewModel::count();
            $todayViews     = ViewModel::whereDate('view_date_timestamp', Carbon::today())->count();
            $activeProducts = ViewModel::distinct('product_id')->count('product_id');

            $days      = 30;
            $startDate = Carbon::now()->subDays($days - 1)->startOfDay();

            $rawDaily = ViewModel::selectRaw('DATE(view_date_timestamp) as view_date, COUNT(*) as total')
                ->where('view_date_timestamp', '>=', $startDate)
                ->groupBy('view_date')
                ->orderBy('view_date')
                ->pluck('total', 'view_date');

            $chartLabels = [];
            $chartData   = [];
            for ($i = 0; $i < $days; $i++) {
                $date = $startDate->copy()->addDays($i)->format('Y-m-d');
                $chartLabels[] = Carbon::parse($date)->translatedFormat('d M');
                $chartData[]   = (int) ($rawDaily[$date] ?? 0);
            }

            $topProducts = ViewModel::select('product_id', DB::raw('count(*) as views_count'))
                ->whereNotNull('product_id')
                ->whereHas('product') // <-- เพิ่มบรรทัดนี้ กรองเอาเฉพาะที่ยังมี product อยู่จริง
                ->with('product')
                ->groupBy('product_id')
                ->orderByDesc('views_count')
                ->limit(5)
                ->get();

            return view('dashboard.index', compact(
                'totalViews',
                'todayViews',
                'activeProducts',
                'chartLabels',
                'chartData',
                'topProducts'
            ));
        } catch (\Exception $e) {
            Log::error('Dashboard error: ' . $e->getMessage());
            return view('errors.404');
        }
    }
}
