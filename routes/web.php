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
Route::get('/tim-kiem', [client\SanphamController::class, 'search'])->name('tim-kiem');

Route::prefix('/san-pham')->group(function () {

    Route::get('/', [client\SanphamController::class, 'index'])->name('danhsachsanpham');

    Route::get('/{slug}', [client\SanphamController::class, 'show'])
        ->name('chi-tiet-san-pham');

    Route::get('/danh-muc/{slug}-{id}', [client\SanphamController::class, 'danhmuc'])
        ->where(['id' => '[0-9]+', 'slug' => '[a-z0-9-]+'])
        ->name('danh-muc-san-pham');
});
    

Route::get('/dang-nhap', [client\NguoidungController::class, 'login'])->name('login');
Route::post('/xac-thuc-dang-nhap', [client\NguoidungController::class, 'handleLogin'])->name('handleLogin');
Route::post('/dang-xuat', [client\NguoidungController::class, 'logout'])->name('logout');

Route::get('/dang-ky', [client\NguoidungController::class, 'register'])->name('register');
Route::post('/xac-thuc-dang-ky', [client\NguoidungController::class, 'handleRegister'])->name('handleRegister');

// Tuyến đường yêu cầu đăng nhập (dành cho mọi người dùng đã đăng nhập)
Route::middleware('auth')->group(function () {
// Route::middleware('auth:web')->group(function () {
    

    // Trang cá nhân
    Route::get('/tai-khoan', [client\NguoidungController::class, 'profile'])->name('tai-khoan');
    Route::put('/cap-nhat-tai-khoan', [client\NguoidungController::class, 'updateProfile'])->name('cap-nhat-tai-khoan');
});

/*
|--------------------------------------------------------------------------
| 2. Admin Routes (Quản trị hệ thống)
|--------------------------------------------------------------------------
| Logic: Yêu cầu Đăng nhập VÀ phải có vai trò 'admin'
*/
Route::middleware(['auth','vaitro:admin']) // Kiểm tra đăng nhập và role
    ->prefix('quan-tri-vien')        // Tất cả route bắt đầu bằng /admin
    ->name('quan-tri-vien')         // Tiền tố tên route: admin.*
    ->group(function () {

        // Trang chính (Dashboard) cho admin
        Route::get('/trang-chu', [admin\AdminDashboardController::class, 'index'])->name('trang-chu');

        // Quản lý sản phẩm
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

        /* ===================== DANH MỤC ===================== */
        Route::prefix('danh-muc')->group(function () {
            Route::get('/danh-sach', [admin\DanhmucController::class, 'index'])->name('danh-sach-danh-muc');
            Route::get('/', [admin\DanhmucController::class, 'index']);

            Route::get('/tao-danh-muc', [admin\DanhmucController::class, 'create'])->name('tao-danh-muc');
            Route::post('/luu', [admin\DanhmucController::class, 'store'])->name('luu-danh-muc');

            Route::get('/{id}/chinh-sua', [admin\DanhmucController::class, 'edit'])->name('chinh-sua-danh-muc');
            Route::post('/{id}/cap-nhat', [admin\DanhmucController::class, 'update'])->name('cap-nhat-danh-muc');

            Route::delete('/{id}/xoa', [admin\DanhmucController::class, 'destroy'])->name('xoa-danh-muc');
        });

        // /* ===================== THƯƠNG HIỆU ===================== */
        // Route::prefix('thuong-hieu')->group(function () {
        //     Route::get('/danh-sach', [ThuonghieuController::class, 'index'])->name('danh-sach-thuong-hieu');
        //     Route::get('/', [ThuonghieuController::class, 'index']);

        //     Route::get('/tao-thuong-hieu', [ThuonghieuController::class, 'create'])->name('tao-thuong-hieu');
        //     Route::post('/luu', [ThuonghieuController::class, 'store'])->name('luu-thuong-hieu');

        //     Route::get('/{id}/chinh-sua', [ThuonghieuController::class, 'edit'])->name('chinh-sua-thuong-hieu');
        //     Route::post('/{id}/cap-nhat', [ThuonghieuController::class, 'update'])->name('cap-nhat-thuong-hieu');

        //     Route::delete('/{id}/xoa', [ThuonghieuController::class, 'destroy'])->name('xoa-thuong-hieu');
        // });

        /* ===================== KHO HÀNG (BIẾN THỂ) ===================== */
        Route::prefix('kho-hang')->group(function () {
            Route::get('/', [admin\BientheController::class, 'index'])->name('danh-sach-kho-hang');
            Route::get('/danh-sach', [admin\BientheController::class, 'index']);

            Route::get('/{id}/chinh-sua', [admin\BientheController::class, 'edit'])->name('chinh-sua-hang-ton-kho');
            Route::post('/{id}/cap-nhat', [admin\BientheController::class, 'update'])->name('cap-nhat-hang-ton-kho');
            Route::get('/{id}/xoa', [admin\BientheController::class, 'destroy'])->name('xoa-hang-ton-kho');
        });

        /* ===================== KHÁCH HÀNG ===================== */
        Route::prefix('khach-hang')->group(function () {
            Route::get('/', [admin\NguoidungController::class, 'index'])->name('danh-sach-khach-hang');
            Route::get('/danh-sach', [admin\NguoidungController::class, 'index']);

            // Tạo mới
            Route::get('/tao-khach-hang', [admin\NguoidungController::class, 'create'])->name('tao-khach-hang');
            Route::post('/luu', [admin\NguoidungController::class, 'store'])->name('luu-khach-hang');

            // Chỉnh sửa
            Route::get('/{id}/chinh-sua', [admin\NguoidungController::class, 'edit'])->name('chinh-sua-khach-hang');
            Route::put('/{id}/cap-nhat', [admin\NguoidungController::class, 'update'])->name('cap-nhat-khach-hang');

            // Xem chi tiết (View)
            Route::get('/{id}', [admin\NguoidungController::class, 'show'])->name('chi-tiet-khach-hang');

            // Xóa
            Route::delete('/{id}/xoa', [admin\NguoidungController::class, 'destroy'])->name('xoa-khach-hang');


        });
        /* ===================== CỬA HÀNG ===================== */
        Route::prefix('cua-hang')->group(function () {
            Route::get('/', [admin\CuaHangController::class, 'index'])->name('danh-sach-cua-hang');
            Route::get('/danh-sach', [admin\CuaHangController::class, 'index']);
            // danh-sach-cua-hang chi-tiet-cua-hang tao-cua-hang chinh-sua-cua-hang

            // Tạo mới
            Route::get('/tao-cua-hang', [admin\CuaHangController::class, 'create'])->name('tao-cua-hang');
            Route::post('/luu', [admin\CuaHangController::class, 'store'])->name('luu-cua-hang');

            // Chỉnh sửa
            Route::get('/{id}/chinh-sua', [admin\CuaHangController::class, 'edit'])->name('chinh-sua-cua-hang');
            Route::put('/{id}/cap-nhat', [admin\CuaHangController::class, 'update'])->name('cap-nhat-cua-hang');
            Route::put('/{id}/cap-nhat-tai-khoan', [admin\CuaHangController::class, 'update'])->name('cap-nhat-cua-hang-tai-khoan');
            Route::put('/{id}/cap-nhat-cua-hang-duyet', [admin\CuaHangController::class, 'update'])->name('cap-nhat-cua-hang-duyet');
            Route::put('/{id}/cap-nhat-trang-thai', [admin\CuaHangController::class, 'update'])->name('cap-nhat-trang-thai');
            Route::put('/{id}/cap-nhat-trang-thai-cua-hang', [admin\CuaHangController::class, 'update'])->name('cap-nhat-trang-thai-cua-hang');



            // Xem chi tiết (View)
            Route::get('/{id}', [admin\CuaHangController::class, 'show'])->name('chi-tiet-cua-hang');

            // Xóa
            Route::delete('/{id}/xoa', [admin\CuaHangController::class, 'destroy'])->name('xoa-cua-hang');



        });
        /* ===================== ĐỘI NGŨ QUẢN TRỊ ===================== */
        Route::prefix('doi-ngu-quan-tri')->group(function () {
            Route::get('/', [admin\DoiNguQuanTriController::class, 'index'])->name('danh-sach-doi-ngu-quan-tri');
            Route::get('/danh-sach', [admin\DoiNguQuanTriController::class, 'index']);

            // Tạo mới
            // không thể thêm admin

            // Chỉnh sửa
            Route::get('/{id}/chinh-sua', [admin\DoiNguQuanTriController::class, 'edit'])->name('chinh-sua-doi-ngu-quan-tri');
            Route::put('/{id}/cap-nhat', [admin\DoiNguQuanTriController::class, 'update'])->name('cap-nhat-doi-ngu-quan-tri');

            // Xem chi tiết (View)
            Route::get('/{id}', [admin\DoiNguQuanTriController::class, 'show'])->name('chi-tiet-doi-ngu-quan-tri');

            // Xóa
            Route::delete('/{id}/xoa', [admin\DoiNguQuanTriController::class, 'destroy'])->name('xoa-doi-ngu-quan-tri');

        });

        /* ===================== ĐƠN HÀNG ===================== */
        Route::prefix('don-hang')->group(function () {
            // Danh sách
            Route::get('/danh-sach', [admin\DonhangController::class, 'index'])->name('danh-sach-don-hang');
            Route::get('/', [admin\DonhangController::class, 'index']);

            // Tạo mới
            Route::get('/tao-don-hang', [admin\DonhangController::class, 'create'])->name('tao-don-hang');
            Route::post('/luu', [admin\DonhangController::class, 'store'])->name('luu-don-hang');

            // Chỉnh sửa
            Route::get('/{id}/chinh-sua', [admin\DonhangController::class, 'edit'])->name('chinh-sua-don-hang');
            Route::put('/{id}/cap-nhat', [admin\DonhangController::class, 'update'])->name('cap-nhat-don-hang');

            // Xem chi tiết (View)
            Route::get('/{id}', [admin\DonhangController::class, 'show'])->name('chi-tiet-don-hang');

            // Xóa
            Route::delete('/{id}/xoa', [admin\DonhangController::class, 'destroy'])->name('xoa-don-hang');

            /* ----------- API phụ để làm chức năng nâng cao ----------- */

            // Lấy chi tiết đơn hàng kèm tổng giá (JSON)
            Route::get('/api/{id}', [admin\DonhangController::class, 'showApi']);

            // Cập nhật số lượng sản phẩm trong đơn hàng
            Route::post('/api/{orderId}/items/{itemId}/quantity', [admin\DonhangController::class, 'updateItemQuantity']);

            // Tìm kiếm sản phẩm autocomplete
            Route::get('/api/search-products', [admin\DonhangController::class, 'searchProducts']);
        });




        // Các route khác cho admin (có thể thêm sau)
        // Route::resource('nguoi-dung', Admin\UserController::class);
        // Route::resource('quan-ly-san-pham', Admin\ProductManagementController::class)->only(['index', 'edit', 'update', 'destroy']);
        // Route::resource('bao-cao', Admin\ReportController::class);
});
Route::middleware(['auth','vaitro:seller']) // Kiểm tra đăng nhập và role
    ->prefix('nguoi-ban-hang')        // Tất cả route bắt đầu bằng /admin
    ->name('nguoi-ban-hang.')         // Tiền tố tên route: admin.*
    ->group(function () {

        // Trang chính (Dashboard) cho admin
        Route::get('/trang-chu', [admin\SellerDashboardController::class, 'index'])->name('trang-chu');

        // Quản lý sản phẩm
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

        /* ===================== DANH MỤC ===================== */
        Route::prefix('danh-muc')->group(function () {
            Route::get('/danh-sach', [admin\DanhmucController::class, 'index'])->name('danh-sach-danh-muc');
            Route::get('/', [admin\DanhmucController::class, 'index']);

            Route::get('/tao-danh-muc', [admin\DanhmucController::class, 'create'])->name('tao-danh-muc');
            Route::post('/luu', [admin\DanhmucController::class, 'store'])->name('luu-danh-muc');

            Route::get('/{id}/chinh-sua', [admin\DanhmucController::class, 'edit'])->name('chinh-sua-danh-muc');
            Route::post('/{id}/cap-nhat', [admin\DanhmucController::class, 'update'])->name('cap-nhat-danh-muc');

            Route::delete('/{id}/xoa', [admin\DanhmucController::class, 'destroy'])->name('xoa-danh-muc');
        });

        // /* ===================== THƯƠNG HIỆU ===================== */
        // Route::prefix('thuong-hieu')->group(function () {
        //     Route::get('/danh-sach', [ThuonghieuController::class, 'index'])->name('danh-sach-thuong-hieu');
        //     Route::get('/', [ThuonghieuController::class, 'index']);

        //     Route::get('/tao-thuong-hieu', [ThuonghieuController::class, 'create'])->name('tao-thuong-hieu');
        //     Route::post('/luu', [ThuonghieuController::class, 'store'])->name('luu-thuong-hieu');

        //     Route::get('/{id}/chinh-sua', [ThuonghieuController::class, 'edit'])->name('chinh-sua-thuong-hieu');
        //     Route::post('/{id}/cap-nhat', [ThuonghieuController::class, 'update'])->name('cap-nhat-thuong-hieu');

        //     Route::delete('/{id}/xoa', [ThuonghieuController::class, 'destroy'])->name('xoa-thuong-hieu');
        // });

        /* ===================== KHO HÀNG (BIẾN THỂ) ===================== */
        Route::prefix('kho-hang')->group(function () {
            Route::get('/', [admin\BientheController::class, 'index'])->name('danh-sach-kho-hang');
            Route::get('/danh-sach', [admin\BientheController::class, 'index']);

            Route::get('/{id}/chinh-sua', [admin\BientheController::class, 'edit'])->name('chinh-sua-hang-ton-kho');
            Route::post('/{id}/cap-nhat', [admin\BientheController::class, 'update'])->name('cap-nhat-hang-ton-kho');
            Route::get('/{id}/xoa', [admin\BientheController::class, 'destroy'])->name('xoa-hang-ton-kho');
        });

        /* ===================== KHÁCH HÀNG ===================== */
        Route::prefix('khach-hang')->group(function () {
            Route::get('/', [admin\NguoidungController::class, 'index'])->name('danh-sach-khach-hang');
            Route::get('/danh-sach', [admin\NguoidungController::class, 'index']);

            // Tạo mới
            Route::get('/tao-khach-hang', [admin\NguoidungController::class, 'create'])->name('tao-khach-hang');
            Route::post('/luu', [admin\NguoidungController::class, 'store'])->name('luu-khach-hang');

            // Chỉnh sửa
            Route::get('/{id}/chinh-sua', [admin\NguoidungController::class, 'edit'])->name('chinh-sua-khach-hang');
            Route::put('/{id}/cap-nhat', [admin\NguoidungController::class, 'update'])->name('cap-nhat-khach-hang');

            // Xem chi tiết (View)
            Route::get('/{id}', [admin\NguoidungController::class, 'show'])->name('chi-tiet-khach-hang');

            // Xóa
            Route::delete('/{id}/xoa', [admin\NguoidungController::class, 'destroy'])->name('xoa-khach-hang');


        });
        /* ===================== CỬA HÀNG ===================== */
        Route::prefix('cua-hang')->group(function () {
            Route::get('/', [admin\CuaHangController::class, 'index'])->name('danh-sach-cua-hang');
            Route::get('/danh-sach', [admin\CuaHangController::class, 'index']);
            // danh-sach-cua-hang chi-tiet-cua-hang tao-cua-hang chinh-sua-cua-hang

            // Tạo mới
            Route::get('/tao-cua-hang', [admin\CuaHangController::class, 'create'])->name('tao-cua-hang');
            Route::post('/luu', [admin\CuaHangController::class, 'store'])->name('luu-cua-hang');

            // Chỉnh sửa
            Route::get('/{id}/chinh-sua', [admin\CuaHangController::class, 'edit'])->name('chinh-sua-cua-hang');
            Route::put('/{id}/cap-nhat', [admin\CuaHangController::class, 'update'])->name('cap-nhat-cua-hang');
            Route::put('/{id}/cap-nhat-tai-khoan', [admin\CuaHangController::class, 'update'])->name('cap-nhat-cua-hang-tai-khoan');
            Route::put('/{id}/cap-nhat-cua-hang-duyet', [admin\CuaHangController::class, 'update'])->name('cap-nhat-cua-hang-duyet');
            Route::put('/{id}/cap-nhat-trang-thai', [admin\CuaHangController::class, 'update'])->name('cap-nhat-trang-thai');
            Route::put('/{id}/cap-nhat-trang-thai-cua-hang', [admin\CuaHangController::class, 'update'])->name('cap-nhat-trang-thai-cua-hang');



            // Xem chi tiết (View)
            Route::get('/{id}', [admin\CuaHangController::class, 'show'])->name('chi-tiet-cua-hang');

            // Xóa
            Route::delete('/{id}/xoa', [admin\CuaHangController::class, 'destroy'])->name('xoa-cua-hang');



        });

        /* ===================== ĐƠN HÀNG ===================== */
        Route::prefix('don-hang')->group(function () {
            // Danh sách
            Route::get('/danh-sach', [admin\DonhangController::class, 'index'])->name('danh-sach-don-hang');
            Route::get('/', [admin\DonhangController::class, 'index']);

            // Tạo mới
            Route::get('/tao-don-hang', [admin\DonhangController::class, 'create'])->name('tao-don-hang');
            Route::post('/luu', [admin\DonhangController::class, 'store'])->name('luu-don-hang');

            // Chỉnh sửa
            Route::get('/{id}/chinh-sua', [admin\DonhangController::class, 'edit'])->name('chinh-sua-don-hang');
            Route::put('/{id}/cap-nhat', [admin\DonhangController::class, 'update'])->name('cap-nhat-don-hang');

            // Xem chi tiết (View)
            Route::get('/{id}', [admin\DonhangController::class, 'show'])->name('chi-tiet-don-hang');

            // Xóa
            Route::delete('/{id}/xoa', [admin\DonhangController::class, 'destroy'])->name('xoa-don-hang');

            /* ----------- API phụ để làm chức năng nâng cao ----------- */

            // Lấy chi tiết đơn hàng kèm tổng giá (JSON)
            Route::get('/api/{id}', [admin\DonhangController::class, 'showApi']);

            // Cập nhật số lượng sản phẩm trong đơn hàng
            Route::post('/api/{orderId}/items/{itemId}/quantity', [admin\DonhangController::class, 'updateItemQuantity']);

            // Tìm kiếm sản phẩm autocomplete
            Route::get('/api/search-products', [admin\DonhangController::class, 'searchProducts']);
        });



        // Các route khác cho admin (có thể thêm sau)
        // Route::resource('nguoi-dung', Admin\UserController::class);
        // Route::resource('quan-ly-san-pham', Admin\ProductManagementController::class)->only(['index', 'edit', 'update', 'destroy']);
        // Route::resource('bao-cao', Admin\ReportController::class);
});


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


