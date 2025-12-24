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
// Fallback Route: Bắt mọi link không tồn tại và chạy qua Middleware 'web'
Route::fallback(function () {
    return response()->view('errors.404', [], 404);
});


Route::get('/', [client\HomeController::class, 'index'])->name('trang-chu');
Route::get('/trang-chu', [client\HomeController::class, 'index']);
Route::get('/tim-kiem', [client\SanphamController::class, 'search'])->name('tim-kiem');

Route::prefix('/san-pham')->group(function () {

    Route::get('/', [client\SanphamController::class, 'index'])->name('danhsachsanpham');
    Route::get('/{slug}', [client\SanphamController::class, 'show'])->name('chi-tiet-san-pham');
});

Route::prefix('/bai-viet')->group(function () {

    Route::get('/', [client\BaivietController::class, 'index'])->name('danh-sach-bai-viet');
    Route::get('/{slug}', [client\BaivietController::class, 'chitiet'])->name('chi-tiet-bai-viet');
});

Route::get('/lien-he', function () {
    return view('client.gioithieu.lienhe');
});

Route::get('/chinh-sach-mua-hang', function () {
    return view('client.gioithieu.chinhsachmuahang');
});

Route::get('/chinh-sach-nguoi-dung', function () {
    return view('client.gioithieu.chinhsachnguoidung');
});

Route::get('/dieu-khoan', function () {
    return view('client.gioithieu.dieukhoan');
});

Route::prefix('/qua-tang')->group(function () {
    Route::get('/', [client\QuatangsukienController::class, 'index'])->name('qua-tang');
    Route::get('/{slug}', [client\QuatangsukienController::class, 'show'])->name('chi-tiet-qua-tang');
    Route::post('/them-gio-hang', [client\QuatangsukienController::class, 'themgiohang'])->name('qua-tang.them-gio-hang');
});

Route::get('/tra-cuu-don-hang', [client\DonhangController::class, 'tracuudonhang'])->name('tra-cuu-don-hang');
Route::post('/tra-cuu-don-hang', [client\DonhangController::class, 'tracuu'])->name('xu-ly-tra-cuu-don-hang');

Route::middleware('guest')->group(function () {
    Route::get('/dang-nhap', [client\NguoidungController::class, 'login'])->name('login');
    Route::post('/xac-thuc-dang-nhap', [client\NguoidungController::class, 'handleLogin'])->name('handleLogin');

    Route::get('/dang-ky', [client\NguoidungController::class, 'register'])->name('dang-ky');
    Route::post('/xac-thuc-dang-ky', [client\NguoidungController::class, 'handleRegister'])->name('handleRegister');
});

Route::get('auth/google', [client\NguoidungController::class, 'redirectToGoogle'])->name('login.google');
Route::get('auth/google/callback', [client\NguoidungController::class, 'handleGoogleCallback']);

Route::prefix('/gio-hang')->group(function () {
    Route::get('/', function () {
        return view('client.thanhtoan.giohang');
    })->name('gio-hang');

    Route::post('/them-gio-hang', [client\GiohangController::class, 'themgiohang'])->name('them-gio-hang');
});

Route::middleware('auth')->group(function () {

    Route::post('/dang-xuat', [client\NguoidungController::class, 'logout'])->name('dang-xuat');
    Route::get('/thong-tin-ca-nhan', [client\NguoidungController::class, 'profile'])->name('tai-khoan');

    Route::prefix('/thong-bao')->group(function () {
        Route::get('/', [client\ThongbaoController::class, 'index'])->name('thong-bao');
        Route::post('/danh-dau-da-doc', [client\ThongbaoController::class, 'index'])->name('danh-dau-da-doc');
    });

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
        Route::get('/vnpay-return', [client\ThanhtoanController::class, 'vnpayReturn'])->name('vnpay.return');
    });
});

/*
|--------------------------------------------------------------------------
| 2. Admin Routes (Quản trị hệ thống)
|--------------------------------------------------------------------------
| Logic: Yêu cầu Đăng nhập VÀ phải có vai trò 'admin'
*/
Route::middleware(['auth', 'vaitro:admin']) // Kiểm tra đăng nhập và role
    ->prefix('quan-tri-vien')        // Tất cả route bắt đầu bằng /admin
    ->name('quan-tri-vien.')         // Tiền tố tên route: admin.*
    ->group(function () {

        Route::get('/', [admin\HomeController::class, 'index'])->name('trang-chu');
        Route::get('/trang-chu', [admin\HomeController::class, 'index']);
        Route::get('/thong-ke-doanh-thu', [admin\HomeController::class, 'getThongKeDoanhThu'])->name('thong-ke-doanh-thu');


        /* ===================== SẢN PHẨM ===================== */
        Route::prefix('san-pham')->group(function () {
            Route::get('/danh-sach', [admin\SanphamController::class, 'index']);
            Route::get('/', [admin\SanphamController::class, 'index'])->name('danh-sach-san-pham');

            Route::get('/tao-san-pham', [admin\SanphamController::class, 'create'])->name('tao-san-pham');
            Route::post('/luu', [admin\SanphamController::class, 'store'])->name('luu-san-pham');

            Route::get('/{slug}-{id}', [admin\SanphamController::class, 'show'])
                ->where(['id' => '[0-9]+', 'slug' => '[a-z0-9-]+'])
                ->name('chi-tiet-san-pham');

            Route::get('/{id}/chinh-sua', [admin\SanphamController::class, 'edit'])->name('chinh-sua-san-pham');
            Route::put('/{id}/cap-nhat', [admin\SanphamController::class, 'update'])->name('cap-nhat-san-pham'); // giữ POST theo dự án
            Route::get('/{id}/xoa', [admin\SanphamController::class, 'destroy'])->name('xoa-san-pham');           // giữ GET theo dự án
        });

        /* ===================== DANH MỤC ===================== */
        Route::prefix('danh-muc')->group(function () {
            Route::get('/danh-sach', [admin\DanhmucController::class, 'index']);
            Route::get('/', [admin\DanhmucController::class, 'index'])->name('danh-sach-danh-muc');

            Route::get('/tao-danh-muc', [admin\DanhmucController::class, 'create'])->name('tao-danh-muc');
            Route::post('/luu', [admin\DanhmucController::class, 'store'])->name('luu-danh-muc');

            Route::get('/{slug}/chinh-sua', [admin\DanhmucController::class, 'edit'])->name('chinh-sua-danh-muc');
            Route::post('/{slug}/cap-nhat', [admin\DanhmucController::class, 'update'])->name('cap-nhat-danh-muc');

            Route::get('/{id}/xoa', [admin\DanhmucController::class, 'destroy'])->name('xoa-danh-muc');
        });

        Route::prefix('thuong-hieu')->group(function () {
            Route::get('/danh-sach', [admin\ThuonghieuController::class, 'index']);
            Route::get('/', [admin\ThuonghieuController::class, 'index'])->name('danh-sach-thuong-hieu');

            Route::get('/tao-thuong-hieu', [admin\ThuonghieuController::class, 'create'])->name('tao-thuong-hieu');
            Route::post('/luu', [admin\ThuonghieuController::class, 'store'])->name('luu-thuong-hieu');

            Route::get('/{slug}/chinh-sua', [admin\ThuonghieuController::class, 'edit'])->name('chinh-sua-thuong-hieu');
            Route::post('/{slug}/cap-nhat', [admin\ThuonghieuController::class, 'update'])->name('cap-nhat-thuong-hieu');

            Route::get('/{id}/xoa', [admin\ThuonghieuController::class, 'destroy'])->name('xoa-thuong-hieu');
        });

        Route::prefix('qua-tang')->group(function () {
            Route::get('/danh-sach', [admin\QuatangsukienController::class, 'index']);
            Route::get('/', [admin\QuatangsukienController::class, 'index'])->name('danh-sach-qua-tang');

            Route::get('/tao-qua-tang', [admin\QuatangsukienController::class, 'create'])->name('tao-qua-tang');
            Route::post('/luu', [admin\QuatangsukienController::class, 'store'])->name('luu-qua-tang');

            Route::get('/{id}/chinh-sua', [admin\QuatangsukienController::class, 'edit'])->name('chinh-sua-qua-tang');
            Route::put('/{id}/cap-nhat', [admin\QuatangsukienController::class, 'update'])->name('cap-nhat-qua-tang');

            Route::get('/{id}/xoa', [admin\QuatangsukienController::class, 'destroy'])->name('xoa-qua-tang');
        });



        Route::prefix('don-hang')->group(function () {
            Route::get('/danh-sach', [admin\DonhangController::class, 'index']);
            Route::get('/', [admin\DonhangController::class, 'index'])->name('danh-sach-don-hang');
            Route::get('/{madon}', [admin\DonhangController::class, 'show'])
                ->name('chi-tiet-don-hang');
            Route::put('/cap-nhat-trang-thai/{id}', [admin\DonhangController::class, 'actionCapNhatTrangThai'])->name('cap-nhat-trang-thai');
            Route::put('/da-thanh-toan/{id}', [admin\DonhangController::class, 'actionDaThanhToan'])->name('da-thanh-toan');
        });

        Route::prefix('/ma-giam-gia')->group(function () {
            Route::get('/', [admin\MagiamgiaController::class, 'index'])->name('danh-sach-ma-giam-gia');

            Route::get('/tao-moi', [admin\MagiamgiaController::class, 'create'])->name('tao-ma-giam-gia');
            Route::post('/luu', [admin\MagiamgiaController::class, 'store'])->name('luu-ma-giam-gia');

            Route::get('/sua/{id}', [admin\MagiamgiaController::class, 'edit'])->name('chinh-sua-ma-giam-gia');
            Route::put('/cap-nhat/{id}', [admin\MagiamgiaController::class, 'update'])->name('cap-nhat-ma-giam-gia');

            Route::get('/xoa/{id}', [admin\MagiamgiaController::class, 'destroy'])->name('xoa-ma-giam-gia');
        });

            // Danh sách
        Route::get('/nguoi-dung', [admin\NguoidungController::class, 'index'])->name('danh-sach-nguoi-dung');
        
        // Form xem chi tiết
        Route::get('/nguoi-dung/doi-trang-thai/{id}', [admin\NguoidungController::class, 'actionKhoataikhoan'])->name('khoa-tai-khoan');
        Route::get('/nguoi-dung/doi-vai-tro/{id}', [admin\NguoidungController::class, 'actionVaitro'])
    ->name('doi-vai-tro');
        
    });
