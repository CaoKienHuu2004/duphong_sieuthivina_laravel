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
        ],[
            'username.required' => 'Vui lòng nhập Tên tài khoản để đăng nhập.',
            'username.string' => 'Tên tài khoản không hợp lệ.',
            'password.required' => 'Vui lòng nhập Mật khẩu.',
            'password.string' => 'Mật khẩu không hợp lệ.',
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
            'hoten' => 'required|string|max:255',
            'username' => 'required|string|max:255|unique:nguoidung,username',
            'email' => 'required|email:rfc,dns|unique:nguoidung,email',
            'sodienthoai' => 'required|string|max:20|unique:nguoidung,sodienthoai',
            'password' => 'required|string|min:6|confirmed',
        ],[
            // Username (Tên tài khoản)
            'username.required' => 'Vui lòng nhập tên tài khoản.',
            'username.string' => 'Tên tài khoản phải là chuỗi ký tự.',
            'username.max' => 'Tên tài khoản không được vượt quá :max ký tự.',
            'username.unique' => 'Tên tài khoản này đã được sử dụng. Vui lòng chọn tên khác.',
            
            // Password (Mật khẩu)
            'password.required' => 'Vui lòng nhập mật khẩu.',
            'password.string' => 'Mật khẩu phải là chuỗi ký tự.',
            'password.min' => 'Mật khẩu phải có ít nhất :min ký tự.',
            'password.confirmed' => 'Xác nhận mật khẩu không khớp.',
            
            // Hoten (Họ tên)
            'hoten.required' => 'Vui lòng nhập họ và tên.',
            'hoten.string' => 'Họ và tên phải là chuỗi ký tự.',
            'hoten.max' => 'Họ và tên không được vượt quá :max ký tự.',

            // Email
            'email.required' => 'Vui lòng nhập địa chỉ email.',
            'email.email' => 'Địa chỉ email không đúng định dạng.',
            'email.unique' => 'Địa chỉ email này đã được đăng ký.',
            
            // Sodienthoai (Số điện thoại)
            'sodienthoai.required' => 'Vui lòng nhập số điện thoại.',
            'sodienthoai.string' => 'Số điện thoại không hợp lệ.',
            'sodienthoai.max' => 'Số điện thoại không được vượt quá :max ký tự.',
            'sodienthoai.unique' => 'Số điện thoại này đã được đăng ký.',
        ]);

        $user = NguoidungModel::create([
            'username' => $request->username,
            'password' => Hash::make($request->password), // Sẽ được hash tự động nhờ cast
            'hoten' => $request->hoten,
            'email' => $request->email,
            'sodienthoai' => $request->sodienthoai,
            'vaitro' => 'client', // Mặc định là user
            'trangthai' => 'Hoạt động', // Mặc định active
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
            $user->avatar = $fileName;
            $user->save();

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

    public function donhangcuatoi()
    {
        return view('client.nguoidung.donhang');
    }
}
