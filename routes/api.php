<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\client\api\HomeController;
use App\Http\Controllers\client\api\SanphamController;
use App\Http\Controllers\client\api\NguoidungController;
use App\Http\Controllers\client\api\QuatangsukienController;
use App\Http\Controllers\client\api\BaivietController;
use App\Http\Controllers\client\api\GiohangController;
use App\Http\Controllers\client\api\ThanhtoanController;
use App\Http\Controllers\client\api\DonhangController;
use App\Http\Controllers\client\api\DiachiController;
use App\Http\Controllers\client\api\DanhgiaController;
use App\Http\Controllers\client\api\GlobalController;
use App\Http\Controllers\client\api\ThongbaoController;
use App\Http\Controllers\client\api\YeuthichController;


/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/


Route::prefix('v1')->group(function () {
    Route::get('/header-data', [GlobalController::class, 'getHeaderData']);

    Route::get('/trang-chu', [HomeController::class, 'index']);

    Route::get('/san-pham', [SanphamController::class, 'index']);
    Route::get('/tim-kiem', [SanphamController::class, 'search']);
    Route::get('/san-pham/{slug}', [SanphamController::class, 'show']);
    // --- CÁC ROUTE KHÔNG CẦN ĐĂNG NHẬP ---
    Route::post('/dang-nhap', [NguoidungController::class, 'handleLogin']);
    Route::post('/dang-ky', [NguoidungController::class, 'handleRegister']);
    Route::post('/login-google', [NguoidungController::class, 'loginWithGoogle']);

    Route::middleware('auth:sanctum')->group(function () {
        Route::get('/thong-tin-ca-nhan', [NguoidungController::class, 'profile']);
        Route::post('/thong-tin-ca-nhan/cap-nhat', [NguoidungController::class, 'updateProfile']);
        Route::post('/dang-xuat', [NguoidungController::class, 'logout']);
    });

    Route::get('/qua-tang', [QuatangsukienController::class, 'index']);
    Route::get('/qua-tang/{slug}', [QuatangsukienController::class, 'show']);

    Route::post('/gio-hang/them', [GiohangController::class, 'themgiohang']);
    Route::post('/gio-hang', [GiohangController::class, 'getCartDetails']);
    Route::delete('/gio-hang/xoa/{id_bienthe}', [GiohangController::class, 'xoagiohang']);
    Route::middleware('auth:sanctum')->post('/gio-hang/sync', [GiohangController::class, 'syncCart']);
    // Cập nhật số lượng (Dùng chung cho cả Guest và Auth vì logic Auth check trong controller)
    Route::put('/gio-hang/cap-nhat', [GiohangController::class, 'capnhatgiohang']);

    Route::prefix('bai-viet')->group(function () {
        Route::get('/', [BaivietController::class, 'index']); // Lấy danh sách
        Route::get('/{slug}', [BaivietController::class, 'show']); // Chi tiết bài viết

    });

    Route::middleware('auth:sanctum')->prefix('/thanh-toan')->group(function () {
        // 1. API Đặt hàng (POST)
        Route::post('/dat-hang', [ThanhtoanController::class, 'placeOrder']);

        // 2. API Check kết quả VNPay (GET)
        // FE sẽ gọi API này sau khi VNPay redirect về
        
        // 3. API Thanh toán lại (POST) <--- THÊM DÒNG NÀY
        Route::post('/thanh-toan-lai', [ThanhtoanController::class, 'retryPayment']);
    });
    Route::get('/thanh-toan/vnpay-return', [ThanhtoanController::class, 'vnpayReturn']);

    Route::middleware('auth:sanctum')->prefix('/don-hang')->group(function () {
        // Chi tiết đơn hàng (GET)
        // URL: {{base_url}}/api/v1/orders/detail/STV251221001
        Route::get('/{madon}', [DonhangController::class, 'getOrderDetail']);

        // Hủy đơn hàng (POST)
        // URL: {{base_url}}/api/v1/orders/cancel
        // Body: { "id_donhang": 1, "ly_do": "Đổi ý không mua nữa" }
        Route::post('/huy-don-hang', [DonhangController::class, 'cancelOrder']);

        // Tra cứu đơn hàng (POST) - Bảo mật hơn GET vì gửi SĐT trong Body
        // URL: {{base_url}}/api/v1/orders/tracking
        // Body: { "madon": "STV251221001", "sodienthoai": "0987654321" }
        // 1. Lấy danh sách đơn hàng (index)
        Route::get('/', [DonhangController::class, 'index']);

        // 2. Mua lại đơn hàng cũ (reOrder)
        Route::post('/mua-lai', [DonhangController::class, 'reOrder']);
    });

    Route::post('/don-hang/tra-cuu', [DonhangController::class, 'trackOrder']);

    Route::get('/provinces', [DiachiController::class, 'getProvinces']);

    // Các API cần đăng nhập
    Route::middleware('auth:sanctum')->group(function () {

        // Lấy danh sách
        Route::get('/dia-chi', [DiachiController::class, 'index']);

        // Thêm mới
        Route::post('/dia-chi', [DiachiController::class, 'store']);

        // Xem chi tiết 1 cái
        // Route::get('/dia-chi/{id}', [DiachiController::class, 'show']);

        // Cập nhật thông tin
        Route::put('/dia-chi/{id}', [DiachiController::class, 'update']);

        // Xóa
        Route::delete('/dia-chi/{id}', [DiachiController::class, 'destroy']);

        // Đặt làm mặc định
        Route::patch('/dia-chi/mac-dinh/{id}', [DiachiController::class, 'setDefault']);
    });



    // === NHÓM PUBLIC (Ai cũng xem được) ===
    // Lấy danh sách đánh giá của 1 sản phẩm
    Route::get('/san-pham/{slug}/danh-gia', [DanhgiaController::class, 'index']);

    // === NHÓM PRIVATE (Phải đăng nhập mới được làm) ===
    Route::middleware('auth:sanctum')->group(function () {

        // Gửi đánh giá
        Route::post('/danh-gia', [DanhgiaController::class, 'store']);
    });

    Route::middleware('auth:sanctum')->group(function () {

        // Lấy danh sách (kèm số lượng chưa đọc)
        Route::get('/thong-bao', [ThongbaoController::class, 'index']);

        // Đánh dấu 1 cái đã đọc
        Route::post('/thong-bao/read', [ThongbaoController::class, 'markAsRead']);

        // Đánh dấu tất cả đã đọc
        Route::post('/thong-bao/read-all', [ThongbaoController::class, 'markAllRead']);

        // Xóa thông báo
        Route::delete('/thong-bao/{id}', [ThongbaoController::class, 'destroy']);
    });

    // Gửi mail yêu cầu (Form nhập email)
    Route::post('/mat-khau/email', [NguoidungController::class, 'sendResetLink']);

    // Đổi mật khẩu (Form nhập pass mới)
    Route::post('/mat-khau/reset', [NguoidungController::class, 'resetPassword']);

    Route::middleware('auth:sanctum')->group(function () {
        Route::post('/nguoi-dung/doi-mat-khau', [NguoidungController::class, 'changePassword']);
    });

    Route::post('/lien-he', [GlobalController::class, 'submitContact']);

    Route::middleware('auth:sanctum')->prefix('yeu-thich')->group(function () {
    // Lấy danh sách: GET /api/v1/yeu-thich
    Route::get('/', [YeuthichController::class, 'index']);

    // Thêm mới: POST /api/v1/yeu-thich
    // Body: { "id_sanpham": 1 }
    Route::post('/', [YeuthichController::class, 'store']);

    // Xóa: DELETE /api/v1/yeu-thich/{id_sanpham}
    Route::delete('/{id_sanpham}', [YeuthichController::class, 'destroy']);
});
});
