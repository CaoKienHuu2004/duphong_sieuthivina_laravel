<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use App\Models\NguoidungModel;
use App\Traits\ApiResponse;

class AuthApiToken
{
    use ApiResponse;
    public function handle(Request $request, Closure $next)
    {
        $token = $request->bearerToken();

        if (!$token) {
            return $this->jsonResponse([
                'success' => false,
                'message' => 'Thiếu token xác thực!',
            ], 401);
        }

        $user = NguoidungModel::where('api_token', hash('sha256', $token))->first();

        if (!$user) {
            return $this->jsonResponse([
                'success' => false,
                'message' => 'Token không hợp lệ hoặc đã hết hạn!',
            ], 401);
        }

        // Gán user vào request để dùng ở controller
        $request->merge(['auth_user' => $user]);

        return $next($request);
    }
}
