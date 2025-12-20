<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class Authenticate
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Kiểm tra: Nếu là API thì check guard sanctum, nếu là Web thì check guard web
        $guard = $request->expectsJson() ? 'sanctum' : 'web';

        if (!Auth::guard($guard)->check()) {
            if ($request->expectsJson()) {
                return response()->json(['message' => 'Bạn chưa đăng nhập hoặc phiên làm việc hết hạn.'], 401);
            }

            return redirect()->route('login');
        }

        return $next($request);
    }
}
