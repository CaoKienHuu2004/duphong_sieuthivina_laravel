<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\client\api\HomeController;
use App\Http\Controllers\client\api\SanphamController;
use App\Http\Controllers\client\api\NguoidungController;


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
        // Route::get('/address', [ApiNguoidungController::class, 'getMyAddress']);
        // Route::post('/address/add', [ApiNguoidungController::class, 'addAddress']);
        // Route::delete('/address/delete/{id}', [ApiNguoidungController::class, 'deleteAddress']);
        
    });
});