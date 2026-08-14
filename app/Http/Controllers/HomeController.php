<?php

namespace App\Http\Controllers;

use App\Models\AdminModel;
use Illuminate\Http\Request;
use App\Models\ProductModel;
use App\Models\CategoryModel;
use App\Models\CustomerModel;
use App\Models\QuotationModel;
use App\Models\ViewModel;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\Log;

class HomeController extends Controller
{
    public function index(Request $request)
    {
        Paginator::useBootstrap();
        ViewModel::create([
                'product_id'          => null,
                'view_date_timestamp' => now(),
            ]);

        $query = ProductModel::where('is_active', true)
            ->orderBy('product_id', 'desc');

        if ($request->filled('category_id')) {
            $query->where('category_id', $request->category_id);
        }

        if ($request->filled('search')) {
            $query->where('product_name', 'LIKE', '%' . $request->search . '%');
        }

        $products = $query->paginate(8)->withQueryString();

        $categories = CategoryModel::orderBy('category_name')->get();

        $totalProducts = ProductModel::where('is_active', true)->count();

        $totalCustomers = CustomerModel::count();

        $latestQuotationNo = QuotationModel::latest('quotation_id')
            ->value('quotation_no');

        return view('home.product_index', compact(
            'products',
            'categories',
            'totalProducts',
            'totalCustomers',
            'latestQuotationNo'
        ));
    }

    public function detail($id)
    {
        $products = ProductModel::with('images')
            ->where('is_active', true)
            ->findOrFail($id);

        try {
            $products->increment('view_count');

            ViewModel::create([
                'product_id'          => $products->product_id,
                'view_date_timestamp' => now(),
            ]);
        } catch (\Throwable $e) {
            Log::error('Failed to record product view: ' . $e->getMessage());
        }

        $categories = CategoryModel::orderBy('category_name')->get();

        $totalProducts = ProductModel::where('is_active', true)->count();

        $totalCustomers = CustomerModel::count();

        $latestQuotationNo = QuotationModel::latest('quotation_id')
            ->value('quotation_no');

        return view('home.product_detail', compact(
            'products',
            'categories',
            'totalProducts',
            'totalCustomers',
            'latestQuotationNo'
        ));
    }

     public function about()
    {
        return view('home.about');
    }

     public function contact()
    {
        return view('home.contact');
    }
}
