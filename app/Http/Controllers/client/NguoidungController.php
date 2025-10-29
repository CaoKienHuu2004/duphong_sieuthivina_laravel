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
use Illuminate\Support\Facades\File;

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
            'sodienthoai' => 'required|numeric|digits_between:10,12|unique:nguoidung,sodienthoai,' . $user->id,
            'gioitinh' => 'required',
            'ngaysinh' => 'required|date|before_or_equal:today', // Phải là định dạng ngày hợp lệ và không được là ngày trong tương lai
            'email' => 'required|email:rfc,dns|unique:nguoidung,email,' . $user->id,
            'avatar' => 'nullable|max:2048',
        ]);

        // 2. XỬ LÝ ẢNH AVATAR
        if ($request->hasFile('avatar')) {
            
            // Chỉ định đường dẫn thư mục trong public: assets/client/images/thumb
            $publicPath = 'assets/client/images/thumbs';
            $destinationPath = public_path($publicPath); // Đường dẫn vật lý đầy đủ

            // --- TỐI ƯU HÓA TÊN FILE ---
            $file = $request->file('avatar');
            $extension = $file->getClientOriginalExtension();
            
            // Sử dụng uniqid() kết hợp với thời gian và ID để tạo tên file gần như độc nhất
            $fileName = uniqid() . '_' . time() . '_' . $user->id . '.' . $extension; 
            
            // 2a. LƯU FILE MỚI VÀO PUBLIC
            $file->move($destinationPath, $fileName);
            
            // Đường dẫn tương đối để lưu vào DB
            $newAvatarDbPath = $publicPath . '/' . $fileName; 
            $updateData['avatar'] = $newAvatarDbPath;

            // 2b. XÓA FILE CŨ (NẾU CÓ)
            if ($user->avatar) {
                $oldAvatarPath = public_path($user->avatar);
                
                // Dùng File::exists() và File::delete() để xóa file
                if (File::exists($oldAvatarPath)) {
                    File::delete($oldAvatarPath);
                }
            }
        }

        NguoidungModel::where('id', $user->id)->update([
            'hoten' => $request->hoten,
            'gioitinh' => $request->gioitinh,
            'ngaysinh' => $request->ngaysinh,
            'sodienthoai' => $request->sodienthoai,
            'email' => $request->email,
        ]);

        return back()->with('success', 'Cập nhật thông tin thành công!');
    }
}
