<?php

namespace App\Http\Controllers\API\Frontend;

use App\Http\Controllers\API\NguoidungAPI;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use App\Models\Nguoidung;
use App\Models\NguoidungModel;
use Illuminate\Support\Facades\Hash;

class AuthFrontendController extends BaseFrontendController
{
    // Đăng nhập
    public function login(Request $req)
    {
        $req->validate([
            'username' => 'required|string',
            'password' => 'required|string',
        ]);

        $user = NguoidungModel::where('username', $req->username)->first();

        if (!$user || !Hash::check($req->password, $user->password)) {
            return $this->jsonResponse([
                'success' => false,
                'message' => "Tên đăng nhập hoặc mật khẩu không chính xác 😓"
            ], 401);
        }

        // Tạo token mới
        $token = Str::random(60);
        $user->api_token = hash('sha256', $token);
        $user->save();

        return $this->jsonResponse([
            'success' => true,
            'token' => $token, // trả về token chưa hash cho client
            'message' => "Đăng Nhập Thành Công"
        ]);
    }

    // Thông tin người dùng (profile)
    public function profile(Request $req)
    {
        $user = NguoidungModel::where('api_token', $req->bearerToken())->first();

        if (!$user) {
            return $this->jsonResponse([
                'success' => false,
                'message' => 'Token không hợp lệ hoặc đã hết hạn!',
            ], 401);
        }

        return $this->jsonResponse([
            'success' => true,
            'user' => $user,
        ]);
    }

    // Đăng xuất
    public function logout(Request $req)
    {
        $user = NguoidungModel::where('api_token', $req->bearerToken())->first();

        if ($user) {
            $user->api_token = null;
            $user->save();
        }

        return $this->jsonResponse([
            'success' => true,
            'message' => "Đăng Xuất Thành Công"
        ]);
    }

    // Đăng ký
    public function register(Request $req)
    {
        $name = $req->name;
        $username = $req->username;
        $password = $req->password;
        $password_confirmation = $req->password_confirmation;

        if (!$name || !$username || !$password || !$password_confirmation) {
            return $this->jsonResponse([
                'success' => false,
                'message' => "Vui Lòng Nhập Đầy Đủ Thông Tin🤩",
            ], 400);
        }

        if ($password != $password_confirmation) {
            return $this->jsonResponse([
                'success' => false,
                'message' => "Mật Khẩu Xác Nhận Không Khớp🤩",
            ], 400);
        }

        if (NguoidungModel::where('username', $username)->exists()) {
            return $this->jsonResponse([
                'success' => false,
                'message' => "Tên tài khoản Này Đã Được Sử Dụng🤩",
            ], 400);
        }

        $user = NguoidungModel::create([
            'name' => $name,
            'username' => $username,
            'password' => bcrypt($password),
            'api_token' => Str::random(60),
        ]);

        return $this->jsonResponse([
            'success' => true,
            'token' => $user->api_token,
            'message' => "Đăng Ký Thành Công"
        ]);
    }
}
