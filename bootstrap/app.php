<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        api: __DIR__.'/../routes/api.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware): void {

        $middleware->statefulApi();
        $middleware->validateCsrfTokens(except: [
            'api/v1/dang-ky', 'api/v1/dang-nhap', 'api/v1/thong-tin-ca-nhan/cap-nhat','api/v1/dang-xuat','api/v1/gio-hang/them','api/v1/gio-hang','api/v1/gio-hang/sync','api/v1/gio-hang/xoa/{id_bienthe}','api/v1/thanh-toan/dat-hang','api/v1/thanh-toan/vnpay-return',
        ]);
        //
        $middleware->alias([
            // 'auth' => \App\Http\Middleware\Authenticate::class,
            'vaitro' => \App\Http\Middleware\Vaitro::class,
            'auth.api' => \App\Http\Middleware\AuthApiToken::class,
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions): void {
        //
    })->create();


