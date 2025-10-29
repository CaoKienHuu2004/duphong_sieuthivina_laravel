<?php

namespace App\Http\Controllers\client;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use PhpParser\Node\Expr\FuncCall;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Auth;
use App\Models\NguoidungModel;

class NguoidungController extends Controller
{

    // Hiển thị form đăng nhập
    public function login()
    {
        return view('client.nguoidung.login');
    }

    // Xử lý đăng nhập
    public function handleLogin(Request $request)
    {
        $request->validate([
            'username' => 'required|string',
            'password' => 'required|string',
        ]);

        $credentials = $request->only('username', 'password');

        if (Auth::attempt($credentials, $request->boolean('remember'))) {
            $request->session()->regenerate();

            $user = Auth::user();

            // Kiểm tra trạng thái tài khoản
            if (!$user->trangthai) {
                Auth::logout();
                return back()->withErrors([
                    'username' => 'Tài khoản của bạn đã bị khóa.',
                ]);
            }

            // Chuyển hướng theo vai trò
            if ($user->vaitro === 'admin') {
                return redirect()->intended(route('quan-tri-vien.trang-chu'));
            } elseif ($user->vaitro === 'seller') {
                return redirect()->intended(route('nguoi-ban-hang.trang-chu'));
            } else {
                return redirect()->intended(route('trang-chu'));
            }
        }

        // Sai thông tin
        return back()->withErrors([
            'username' => 'Tên tài khoản hoặc mật khẩu không đúng.',
        ])->withInput($request->only('username'));
    }

    // Đăng xuất
    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('trang-chu');
    }

    // Hiển thị form đăng ký
    public function register()
    {
        return view('client.nguoidung.dangky');
    }

    // Xử lý đăng ký
    public function handleRegister(Request $request)
    {
        $request->validate([
            'username' => 'required|string|max:255|unique:nguoidung,username',
            'password' => 'required|string|min:6|confirmed',
            'hoten' => 'required|string|max:255',
            'sodienthoai' => 'required|string|max:20|unique:nguoidung,sodienthoai',
            'gioitinh' => 'required|in:nam,nu,khac',
            'ngaysinh' => 'required|date|before:today',
        ]);

        $user = NguoidungModel::create([
            'username' => $request->username,
            'password' => Hash::make($request->password), // Sẽ được hash tự động nhờ cast
            'hoten' => $request->hoten,
            'sodienthoai' => $request->sodienthoai,
            'gioitinh' => $request->gioitinh,
            'ngaysinh' => $request->ngaysinh,
            'vaitro' => 'client', // Mặc định là user
            'trangthai' => true, // Mặc định active
        ]);

        // Tự động đăng nhập sau khi đăng ký
        Auth::login($user);

        return redirect()->route('trang-chu')->with('success', 'Đăng ký thành công!');
    }

    // Hiển thị trang cá nhân
    public function profile()
    {
        $user = Auth::user();
        return view('client.nguoidung.thongtin', compact('user'));
    }

    // Cập nhật thông tin cá nhân
    public function updateProfile(Request $request)
    {
        $user = Auth::user();

        $request->validate([
            'hoten' => 'required',
            // 'sodienthoai' => 'required|string|max:20|unique:nguoidung,sodienthoai,' . $user->id,
            'gioitinh' => 'required',
            'ngaysinh' => 'required',
        ]);

        NguoidungModel::where('id', $user->id)->update([
            'hoten' => $request->hoten,
            // 'sodienthoai' => $request->sodienthoai,
            'gioitinh' => $request->gioitinh,
            'ngaysinh' => $request->ngaysinh,
        ]);

        return back()->with('success', 'Cập nhật thông tin thành công!');
    }
}
