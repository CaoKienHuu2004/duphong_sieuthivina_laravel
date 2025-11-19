<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class Vaitro
{
    /**
     * Xử lý yêu cầu vào middleware.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  string  ...$roles
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function handle(Request $request, Closure $next, ...$roles): Response
    {
        // Nếu chưa đăng nhập thì chuyển hướng về trang login
        if (!Auth::check()) {
            return redirect()->route('login');
        }

        $user = Auth::user();

        // Nếu vai trò KHÔNG nằm trong danh sách cho phép
        if (!in_array($user->vaitro, $roles)) {
            // Nếu là admin thì chuyển về trang chủ admin
            if ($user->vaitro === 'admin') {
                return redirect()->route('quan-tri-vien.trang-chu');
            }

            return redirect()->route('trang-chu');
        }
        return $next($request);
    }
}
