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
        //
        $middleware->alias([
            'auth' => \App\Http\Middleware\Authenticate::class,
            'vaitro' => \App\Http\Middleware\Vaitro::class,
            'auth.api' => \App\Http\Middleware\AuthApiToken::class,
            // 'cors' => \App\Http\Middleware\Cors::class,

        ]);
        // $middleware->prepend('api', 'cors');
    })
    ->withExceptions(function (Exceptions $exceptions): void {
        //
    })->create();
