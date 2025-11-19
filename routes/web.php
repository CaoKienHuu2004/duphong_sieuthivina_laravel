<?php

use Illuminate\Support\Facades\Route;
// Đảm bảo import đúng Controllers theo cấu trúc thư mục
use App\Http\Controllers\client;
use App\Http\Controllers\admin;
use App\Http\Controllers\vendor;
use App\Livewire;

/*
|--------------------------------------------------------------------------
| 1. Client Routes (Cộng đồng và Đã đăng nhập)
|--------------------------------------------------------------------------
*/

Route::get('/', [client\HomeController::class, 'index'])->name('trang-chu');
Route::get('/trang-chu', [client\HomeController::class, 'index']);
Route::get('/tim-kiem', [client\SanphamController::class, 'search'])->name('tim-kiem');

Route::prefix('/san-pham')->group(function () {

    Route::get('/', [client\SanphamController::class, 'index'])->name('danhsachsanpham');
    Route::get('/{slug}', [client\SanphamController::class, 'show'])->name('chi-tiet-san-pham');

});

Route::middleware('guest')->group(function () {
    Route::get('/dang-nhap', [client\NguoidungController::class, 'login'])->name('login');
    Route::post('/xac-thuc-dang-nhap', [client\NguoidungController::class, 'handleLogin'])->name('handleLogin');

    Route::get('/dang-ky', [client\NguoidungController::class, 'register'])->name('dang-ky');
    Route::post('/xac-thuc-dang-ky', [client\NguoidungController::class, 'handleRegister'])->name('handleRegister');
});

Route::prefix('/gio-hang')->group(function () {
    Route::get('/', function () {return view('client.thanhtoan.giohang'); })->name('gio-hang');

    Route::post('/them-gio-hang', [client\GiohangController::class, 'themgiohang'])->name('them-gio-hang');
});

Route::middleware('auth')->group(function () {
    
    Route::post('/dang-xuat', [client\NguoidungController::class, 'logout'])->name('dang-xuat');
    Route::get('/thong-tin-ca-nhan', [client\NguoidungController::class, 'profile'])->name('tai-khoan');

    Route::prefix('/don-hang')->group(function () {
        Route::get('/', [client\DonhangController::class, 'donhangcuatoi'])->name('don-hang-cua-toi');
        Route::get('/{madon}', [client\DonhangController::class, 'chitietdonhang'])->name('chi-tiet-don-hang');
        Route::delete('/huy-don-hang', [client\DonhangController::class, 'huydonhang'])->name('huy-don-hang');
    });
    
    Route::get('/so-dia-chi', [client\DiachiController::class, 'index'])->name('so-dia-chi');
    Route::get('/them-dia-chi-giao-hang', [client\DiachiController::class, 'taodiachi'])->name('them-dia-chi-giao-hang');
    Route::post('/luu-dia-chi', [client\DiachiController::class, 'khoitaodiachi'])->name('luu-dia-chi');
    Route::get('/sua-dia-chi/{id}', [client\DiachiController::class, 'suadiachi'])->name('sua-dia-chi');
    Route::put('/cap-nhat-dia-chi', [client\DiachiController::class, 'capnhatdiachi'])->name('cap-nhat-dia-chi');
    Route::delete('/xoa-dia-chi', [client\DiachiController::class, 'xoadiachi'])->name('xoa-dia-chi');
    Route::put('/cap-nhat-tai-khoan', [client\NguoidungController::class, 'updateProfile'])->name('cap-nhat-tai-khoan');
    
    
    Route::prefix('/thanh-toan')->group(function () {
        Route::get('/', [client\ThanhtoanController::class, 'index'])->name('thanh-toan');
        Route::post('/dat-hang', [client\ThanhtoanController::class, 'placeOrder'])->name('dat-hang');
        Route::get('/dat-hang-thanh-cong', [client\ThanhtoanController::class, 'orderSuccess'])->name('dat-hang-thanh-cong');
        Route::get('/thay-doi-dia-chi', [client\DiachiController::class, 'selectAddress'])->name('thay-doi-dia-chi');
        Route::post('/cap-nhat-mac-dinh', [client\DiachiController::class, 'updateDefaultAddress'])->name('cap-nhat-mac-dinh');
    });
});

/*
|--------------------------------------------------------------------------
| 2. Admin Routes (Quản trị hệ thống)
|--------------------------------------------------------------------------
| Logic: Yêu cầu Đăng nhập VÀ phải có vai trò 'admin'
*/
Route::middleware(['auth','vaitro:admin']) // Kiểm tra đăng nhập và role
    ->prefix('quan-tri-vien')        // Tất cả route bắt đầu bằng /admin
    ->name('quan-tri-vien.')         // Tiền tố tên route: admin.*
    ->group(function () {

        Route::get('/trang-chu', [admin\HomeController::class, 'index'])->name('trang-chu');

        /* ===================== SẢN PHẨM ===================== */
        Route::prefix('san-pham')->group(function () {
            Route::get('/danh-sach', [admin\SanphamController::class, 'index'])->name('danh-sach');
            Route::get('/', [admin\SanphamController::class, 'index']);

            Route::get('/tao-san-pham', [admin\SanphamController::class, 'create'])->name('tao-san-pham');
            Route::post('/luu', [admin\SanphamController::class, 'store'])->name('luu-san-pham');

            Route::get('/{slug}-{id}', [admin\SanphamController::class, 'show'])
                ->where(['id' => '[0-9]+', 'slug' => '[a-z0-9-]+'])
                ->name('chi-tiet-san-pham');

            Route::get('/{id}/chinh-sua', [admin\SanphamController::class, 'edit'])->name('chinh-sua-san-pham');
            Route::post('/{id}/cap-nhat', [admin\SanphamController::class, 'update'])->name('cap-nhat-san-pham'); // giữ POST theo dự án
            Route::get('/{id}/xoa', [admin\SanphamController::class, 'destroy'])->name('xoa-san-pham');           // giữ GET theo dự án
        });
        
});



