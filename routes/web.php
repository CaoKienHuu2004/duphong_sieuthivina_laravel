<?php

use Illuminate\Support\Facades\Route;
// Đảm bảo import đúng Controllers theo cấu trúc thư mục
use App\Http\Controllers\client;
use App\Http\Controllers\admin;
use App\Http\Controllers\vendor;

/*
|--------------------------------------------------------------------------
| 1. Client Routes (Cộng đồng và Đã đăng nhập)
|--------------------------------------------------------------------------
*/

// Tuyến đường công khai (Không cần đăng nhập)
Route::get('/', [client\HomeController::class, 'index'])->name('trang-chu');
Route::get('/trang-chu', [client\HomeController::class, 'index']);

// Route xử lý yêu cầu tìm kiếm từ form hoặc từ khóa click
Route::get('/tim-kiem', [client\HomeController::class, 'search'])->name('tim-kiem');

Route::get('/dang-nhap', [client\NguoidungController::class, 'login'])->name('login');
Route::post('/xac-thuc-dang-nhap', [client\NguoidungController::class, 'handleLogin'])->name('handleLogin');
Route::post('/dang-xuat', [client\NguoidungController::class, 'logout'])->name('logout');

Route::get('/dang-ky', [client\NguoidungController::class, 'register'])->name('register');
Route::post('/xac-thuc-dang-ky', [client\NguoidungController::class, 'handleRegister'])->name('handleRegister');

// Tuyến đường yêu cầu đăng nhập (dành cho mọi người dùng đã đăng nhập)
Route::middleware('auth')->group(function () {
// Route::middleware('auth:web')->group(function () {
    // Trang danh sách sản phẩm
    Route::get('/san-pham', [client\SanphamController::class, 'show'])->name('sanpham');
    
    // Trang cá nhân
    Route::get('/tai-khoan', [client\NguoidungController::class, 'profile'])->name('profile');
    Route::put('/tai-khoan', [client\NguoidungController::class, 'updateProfile'])->name('updateProfile');
});

// /*
// |--------------------------------------------------------------------------
// | 2. Admin Routes (Quản trị hệ thống)
// |--------------------------------------------------------------------------
// | Logic: Yêu cầu Đăng nhập VÀ phải có vai trò 'admin'
// */
// Route::middleware(['auth:web', 'role:admin']) // Áp dụng Middleware kiểm tra Role
//       ->prefix('admin')                      // Tiền tố URL: /admin/...
//       ->name('admin.')                       // Tiền tố tên Route: admin.dashboard
//       ->group(function () {

//     Route::get('/', [Admin\DashboardController::class, 'index'])->name('dashboard');

//     // Quản lý người dùng và phân quyền
//     Route::resource('users', Admin\UserController::class);

//     // Duyệt sản phẩm và cấu hình hệ thống
//     Route::resource('products-management', Admin\ProductManagementController::class)->only(['index', 'edit', 'update', 'destroy']);

//     // Quản lý các loại báo cáo/khiếu nại từ người dùng
//     Route::resource('reports', Admin\ReportController::class);
// });


// /*
// |--------------------------------------------------------------------------
// | 3. Seller Routes (Quản lý cửa hàng)
// |--------------------------------------------------------------------------
// | Logic: Yêu cầu Đăng nhập VÀ phải có vai trò 'seller'
// */
// Route::middleware(['auth:web', 'role:seller']) // Áp dụng Middleware kiểm tra Role
//       ->prefix('seller')                       // Tiền tố URL: /seller/...
//       ->name('seller.')                        // Tiền tố tên Route: seller.dashboard
//       ->group(function () {

//     Route::get('/', [Seller\DashboardController::class, 'index'])->name('dashboard');

//     // Quản lý sản phẩm của chính Seller đó
//     Route::resource('products', Seller\ProductController::class);

//     // Quản lý đơn hàng đến từ client
//     Route::get('orders', [Seller\OrderController::class, 'index'])->name('orders.index');
//     Route::patch('orders/{order}/update-status', [Seller\OrderController::class, 'updateStatus'])->name('orders.update_status');
// });
