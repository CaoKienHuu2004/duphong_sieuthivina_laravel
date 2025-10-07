<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class Vaitro
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, string $role)
{
    // $request->user()->role lấy vai trò từ bảng users
    if (! $request->user() || $request->user()->role !== $role) {
        // Chuyển hướng hoặc trả về lỗi 403 (Unauthorized)
        abort(403, 'Unauthorized action.');
    }

    return $next($request);
}
}
