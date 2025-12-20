<?php

namespace App\Http\Controllers\client\api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use App\Http\Resources\NguoidungResource;
// use Illuminate\Support\Facades\Http;
// use Illuminate\Support\Facades\Route;
// use Illuminate\Support\Facades\Uniqid;
// use Illuminate\Support\Facades\PublicPath;
// use Illuminate\Support\Facades\Time;
// use Illuminate\Support\Facades\View;
// use Illuminate\Support\Facades\Session;
use App\Models\NguoidungModel;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Validator;

class NguoidungController extends Controller
{
    // Xử lý đăng nhập
    public function handleLogin(Request $request)
    {
        // Giữ nguyên logic validate
        $validator = Validator::make($request->all(), [
            'username' => 'required|string',
            'password' => 'required|string',
        ], [
            'username.required' => 'Vui lòng nhập Tên tài khoản để đăng nhập.',
            'username.string' => 'Tên tài khoản không hợp lệ.',
            'password.required' => 'Vui lòng nhập Mật khẩu.',
            'password.string' => 'Mật khẩu không hợp lệ.',
        ]);

        if ($validator->fails()) {
            return response()->json(['status' => 422, 'errors' => $validator->errors()], 422);
        }

        $credentials = $request->only('username', 'password');

        if (Auth::attempt($credentials, $request->boolean('remember'))) {
            // Trong API không dùng session regenerate, ta tạo Token thay thế
            $user = Auth::user();

            // Kiểm tra trạng thái tài khoản (Giữ nguyên logic của bạn)
            if (!$user->trangthai) {
                Auth::logout();
                return response()->json([
                    'status' => 403,
                    'message' => 'Tài khoản của bạn đã bị khóa.'
                ], 403);
            }

            // Tạo token (Sanctum)
            $token = $user->createToken('auth_token')->plainTextToken;

            // Chuyển hướng theo vai trò (Thay redirect bằng data vaitro để FE xử lý)
            return response()->json([
                'status' => 200,
                'message' => 'Đăng nhập thành công',
                'access_token' => $token,
                'token_type' => 'Bearer',
                'vaitro' => $user->vaitro,
                'user' => new NguoidungResource($user)
            ]);
        }

        // Sai thông tin (Giữ nguyên logic trả về lỗi)
        return response()->json([
            'status' => 401,
            'message' => 'Tên tài khoản hoặc mật khẩu không đúng.'
        ], 401);
    }

    // Đăng xuất
    public function logout(Request $request)        
    {
        // Xóa token hiện tại (API Logout)
        $request->user()->currentAccessToken()->delete();
        Auth::logout();

        return response()->json([
            'status' => 200,
            'message' => 'Đăng xuất thành công'
        ]);
    }

    // Xử lý đăng ký
    public function handleRegister(Request $request)
    {
        // Giữ nguyên 100% logic validate của bạn
        $validator = Validator::make($request->all(), [
            'hoten' => 'required|string|max:255',
            'username' => 'required|string|max:255|unique:nguoidung,username',
            'email' => 'required|email:rfc,dns|unique:nguoidung,email',
            'sodienthoai' => 'required|string|max:20|unique:nguoidung,sodienthoai',
            'password' => 'required|string|min:6|confirmed',
        ], [
            'username.required' => 'Vui lòng nhập tên tài khoản.',
            'username.string' => 'Tên tài khoản phải là chuỗi ký tự.',
            'username.max' => 'Tên tài khoản không được vượt quá :max ký tự.',
            'username.unique' => 'Tên tài khoản này đã được sử dụng. Vui lòng chọn tên khác.',
            'password.required' => 'Vui lòng nhập mật khẩu.',
            'password.string' => 'Mật khẩu phải là chuỗi ký tự.',
            'password.min' => 'Mật khẩu phải có ít nhất :min ký tự.',
            'password.confirmed' => 'Xác nhận mật khẩu không khớp.',
            'hoten.required' => 'Vui lòng nhập họ và tên.',
            'hoten.string' => 'Họ và tên phải là chuỗi ký tự.',
            'hoten.max' => 'Họ và tên không được vượt quá :max ký tự.',
            'email.required' => 'Vui lòng nhập địa chỉ email.',
            'email.email' => 'Địa chỉ email không đúng định dạng.',
            'email.unique' => 'Địa chỉ email này đã được đăng ký.',
            'sodienthoai.required' => 'Vui lòng nhập số điện thoại.',
            'sodienthoai.string' => 'Số điện thoại không hợp lệ.',
            'sodienthoai.max' => 'Số điện thoại không được vượt quá :max ký tự.',
            'sodienthoai.unique' => 'Số điện thoại này đã được đăng ký.',
        ]);

        if ($validator->fails()) {
            return response()->json(['status' => 422, 'errors' => $validator->errors()], 422);
        }

        // Tạo user (Giữ nguyên logic của bạn)
        $user = NguoidungModel::create([
            'username' => $request->username,
            'password' => Hash::make($request->password), 
            'hoten' => $request->hoten,
            'email' => $request->email,
            'sodienthoai' => $request->sodienthoai,
            'vaitro' => 'client', 
            'trangthai' => 'Hoạt động', 
        ]);

        // Tự động đăng nhập và tạo token
        $token = $user->createToken('auth_token')->plainTextToken;

        return response()->json([
            'status' => 201,
            'message' => 'Đăng ký thành công!',
            'access_token' => $token,
            'user' => new NguoidungResource($user)
        ], 201);
    }

    // Hiển thị trang cá nhân
    public function profile(Request $request)
    {
        $user = $request->user();
        // Nối link full cho avatar để FE hiển thị ngay
        if($user->avatar) {
            $user->avatar = asset('assets/client/images/thumbs/' . $user->avatar);
        }
        return response()->json([
            'status' => 200,
            'user' => new NguoidungResource($request->user())
        ]);
    }

    // Cập nhật thông tin cá nhân
    public function updateProfile(Request $request)
    {
        $user = $request->user(); // Lấy user từ token

        $validator = Validator::make($request->all(), [
            'hoten' => 'required',
            'sodienthoai' => 'required|numeric|digits_between:10,12|unique:nguoidung,sodienthoai,' . $user->id,
            'gioitinh' => 'required',
            'ngaysinh' => 'required|date|before_or_equal:today', 
            'email' => 'required|email:rfc,dns|unique:nguoidung,email,' . $user->id,
        ]);

        if ($validator->fails()) {
            return response()->json(['status' => 422, 'errors' => $validator->errors()], 422);
        }

        // 2. XỬ LÝ ẢNH AVATAR (Giữ nguyên 100% logic xử lý file của bạn)
        if ($request->hasFile('avatar')) {
            $publicPath = 'assets/client/images/thumbs';
            $destinationPath = public_path($publicPath);

            $file = $request->file('avatar');
            $extension = $file->getClientOriginalExtension();
            
            $fileName = uniqid() . '_' . time() . '_' . $user->id . '.' . $extension; 
            
            // 2a. LƯU FILE MỚI VÀO PUBLIC
            $file->move(public_path($publicPath), $fileName);

            // 2b. XÓA FILE CŨ (NẾU CÓ)
            if ($user->avatar) {
                $oldAvatarPath = public_path($publicPath . '/' . $user->avatar);
                if (File::exists($oldAvatarPath)) {
                    File::delete($oldAvatarPath);
                }
            }

            // Cập nhật tên file vào DB
            $user->avatar = $fileName;
            $user->save();
        }

        // Cập nhật thông tin khác (Giữ nguyên logic của bạn)
        NguoidungModel::where('id', $user->id)->update([
            'hoten' => $request->hoten,
            'gioitinh' => $request->gioitinh,
            'ngaysinh' => $request->ngaysinh,
            'sodienthoai' => $request->sodienthoai,
            'email' => $request->email,
        ]);

        return response()->json([
            'status' => 200,
            'message' => 'Cập nhật thông tin thành công!',
            'user' => new NguoidungResource($user->fresh())
        ]);
    }
}