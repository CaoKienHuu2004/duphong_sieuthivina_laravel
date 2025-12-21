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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::prefix('v1')->group(function () {
    Route::get('/trang-chu', [HomeController::class, 'index']);

    Route::get('/san-pham', [SanphamController::class, 'index']);
    Route::get('/tim-kiem', [SanphamController::class, 'search']);
    Route::get('/san-pham/{slug}', [SanphamController::class, 'show']);
    // --- CÁC ROUTE KHÔNG CẦN ĐĂNG NHẬP ---
    Route::post('/dang-nhap', [NguoidungController::class, 'handleLogin']);
    Route::post('/dang-ky', [NguoidungController::class, 'handleRegister']);

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

    Route::prefix('bai-viet')->group(function () {
        Route::get('/', [BaivietController::class, 'index']); // Lấy danh sách
        Route::get('/{slug}', [BaivietController::class, 'show']); // Chi tiết bài viết

    });

    Route::middleware('auth:sanctum')->prefix('/thanh-toan')->group(function () {
        // 1. API Đặt hàng (POST)
        Route::post('/dat-hang', [ThanhtoanController::class, 'placeOrder']);

        // 2. API Check kết quả VNPay (GET)
        // FE sẽ gọi API này sau khi VNPay redirect về
        Route::get('/vnpay-return', [ThanhtoanController::class, 'vnpayReturn']);
    });
});
