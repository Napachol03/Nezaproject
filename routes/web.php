<?php
use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\QuotationController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\DashboardController;

//home page
Route::get('/', [HomeController::class, 'index']);
Route::get('/detail/{product_id}', [HomeController::class, 'detail']);
Route::get('/about', [HomeController::class, 'about']);
Route::get('/contact', [HomeController::class, 'contact']);


//authentication
Route::get('/login', [AuthController::class, 'index'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
//ทำไมต้องมี name('login') ?
//เวลาใช้ auth middleware ถ้า user ยังไม่ login → Laravel จะ redirect ไปหา route ที่ชื่อว่า login โดยอัตโนมัติ
//ถ้าไม่เจอ → มันก็โยน error Route [login] not defined.
//login เสร็จไปหน้า Dashboard
Route::middleware('auth:admin')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');});

//dashboard
Route::get('/dashboard', [DashboardController::class, 'index']);

//product
Route::get('/product', [ProductController::class, 'index']);
Route::get('/product/adding',  [ProductController::class, 'adding']);
Route::post('/product',  [ProductController::class, 'create']);
Route::get('/product/{product_id}',  [ProductController::class, 'edit']);
Route::put('/product/{product_id}',  [ProductController::class, 'update']);
Route::delete('/product/remove/{product_id}', [ProductController::class, 'remove']);

//Category
Route::post('/category', [CategoryController::class, 'create']);

//Admin
//Route::get('/admin/login', [AdminAuthController::class, 'showLoginForm'])->name('login');
Route::get('/admin', [AdminController::class, 'index']);
Route::get('/admin/adding', [AdminController::class, 'adding']);
Route::post('/admin', [AdminController::class, 'create']);
Route::get('/admin/{id}',  [AdminController::class, 'edit']);
Route::put('/admin/{id}',  [AdminController::class, 'update']);
Route::delete('/admin/remove/{id}', [AdminController::class, 'remove']);
Route::get('/admin/reset/{id}',  [AdminController::class, 'reset']);
Route::put('/admin/reset/{id}',  [AdminController::class, 'resetPassword']);

//Customer
Route::get('/customer', [CustomerController::class, 'index']);
Route::get('/customer/adding',  [CustomerController::class, 'adding']);
Route::post('/customer',  [CustomerController::class, 'create']);
Route::get('/customer/{id}',  [CustomerController::class, 'edit']);
Route::put('/customer/{id}',  [CustomerController::class, 'update']);
Route::delete('/customer/remove/{id}',  [CustomerController::class, 'remove']); 
Route::post('/customer/quick', [CustomerController::class, 'store']);  // สำหรับ modal ในฟอร์มใบเสนอราคา

//Quotation
Route::get('/quotation', [QuotationController::class, 'index']);
Route::get('/quotation/adding', [QuotationController::class, 'adding']);
Route::post('/quotation', [QuotationController::class, 'create']);
Route::get('/quotation/{id}',  [QuotationController::class, 'edit']);
Route::put('/quotation/{id}',  [QuotationController::class, 'update']);
Route::delete('/quotation/remove/{id}', [QuotationController::class, 'remove']);
Route::get('/quotation/{id}/print', [QuotationController::class, 'printView']);

