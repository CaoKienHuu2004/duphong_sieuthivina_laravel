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
use Laravel\Socialite\Facades\Socialite;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Filter;
use Illuminate\Support\Facades\DB;

class NguoidungController extends Controller
{
    // Xử lý đăng nhập
    public function handleLogin(Request $request)
    {
        // 1. Validate: Chỉ cần kiểm tra có nhập hay không
        // Ta vẫn giữ key 'username' gửi từ FE để đỡ phải sửa FE, nhưng hiểu ngầm nó là "Tài khoản"
        $validator = Validator::make($request->all(), [
            'phonemail' => 'required|string', // FE gửi lên là 'username' nhưng giá trị là email hoặc sdt
            'password' => 'required|string',
        ], [
            'phonemail.required' => 'Vui lòng nhập Email hoặc Số điện thoại.',
            'phonemail.string' => 'Tài khoản không hợp lệ.',
            'password.required' => 'Vui lòng nhập Mật khẩu.',
            'password.string' => 'Mật khẩu không hợp lệ.',
        ]);

        if ($validator->fails()) {
            return response()->json(['status' => 422, 'errors' => $validator->errors()], 422);
        }

        // 2. Xử lý Logic nhận diện Email hay Số điện thoại
        $loginInput = $request->input('phonemail');

        // Dùng filter_var để kiểm tra xem input có phải là email không
        $fieldType = filter_var($loginInput, FILTER_VALIDATE_EMAIL) ? 'email' : 'sodienthoai';

        // Tạo mảng credentials để Auth kiểm tra đúng cột trong database
        $credentials = [
            $fieldType => $loginInput, // Tự động gán key là 'email' hoặc 'sodienthoai'
            'password' => $request->input('password')
        ];

        // 3. Tiến hành đăng nhập
        if (Auth::attempt($credentials, $request->boolean('remember'))) {
            $user = Auth::user();

            // Kiểm tra trạng thái tài khoản
            if (!$user->trangthai) {
                Auth::logout();
                return response()->json([
                    'status' => 403,
                    'message' => 'Tài khoản của bạn đã bị khóa.'
                ], 403);
            }

            // Tạo Token Sanctum
            $token = $user->createToken('auth_token')->plainTextToken;

            return response()->json([
                'status' => 200,
                'message' => 'Đăng nhập thành công',
                'access_token' => $token,
                'token_type' => 'Bearer',
                'vaitro' => $user->vaitro,
                'user' => new NguoidungResource($user)
            ]);
        }

        // 4. Trả về lỗi nếu sai
        return response()->json([
            'status' => 401,
            'message' => 'Thông tin đăng nhập hoặc mật khẩu không đúng.'
        ], 401);
    }

    public function loginWithGoogle(Request $request)
    {
        // 1. Chỉ nhận token từ FE
        $validator = Validator::make($request->all(), [
            'access_token' => 'required|string',
        ]);

        if ($validator->fails()) {
            return response()->json(['status' => 422, 'errors' => $validator->errors()], 422);
        }

        try {
            // 2. Lấy thông tin Email từ Google (Stateless)
            $googleUser = Socialite::driver('google')->stateless()->userFromToken($request->access_token);
            $googleEmail = $googleUser->getEmail();

            if (!$googleEmail) {
                return response()->json(['status' => 401, 'message' => 'Không lấy được Email từ Google.'], 401);
            }

            // 3. Tự động kiếm mail trong Database
            $user = NguoidungModel::where('email', $googleEmail)->first();

            // 4. Xử lý logic Đăng nhập
            if ($user) {
                // TRƯỜNG HỢP 1: Đã có tài khoản -> Đăng nhập luôn

                // Kiểm tra xem tài khoản có bị khóa không
                if ($user->trangthai == 'Tạm khóa') {
                    return response()->json(['status' => 403, 'message' => 'Tài khoản đã bị khóa.'], 403);
                }
            } else {
                // TRƯỜNG HỢP 2: Chưa có tài khoản -> Tạo mới nhanh (để họ vào luôn)
                // Nếu bạn CHỈ muốn cho người đã đăng ký rồi mới được login, thì xóa đoạn else này và return lỗi 404.

                $user = NguoidungModel::create([
                    'name' => $googleUser->getName() ?? 'Người dùng Google', // Lấy tên từ Google
                    'email' => $googleEmail,
                    'password' => Hash::make(Str::random(16)), // Tạo pass ngẫu nhiên để không bị lỗi DB
                    'vaitro' => 'khachhang',
                    'trangthai' => 1,
                ]);
            }

            // 5. Cấp Token (Giống hệt hàm handleLogin cũ)
            $token = $user->createToken('auth_token')->plainTextToken;

            return response()->json([
                'status' => 200,
                'message' => 'Đăng nhập Google thành công',
                'access_token' => $token,
                'token_type' => 'Bearer',
                'vaitro' => $user->vaitro,
                'user' => new NguoidungResource($user)
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 500,
                'message' => 'Lỗi hệ thống: ' . $e->getMessage()
            ], 500);
        }
    }

    // Đăng xuất
    public function logout(Request $request)
    {
        if ($request->user()) {
            $request->user()->currentAccessToken()->delete();

            return response()->json([
                'status' => 200,
                'message' => 'Đăng xuất thành công, Token đã bị hủy.'
            ]);
        }

        return response()->json([
            'status' => 401,
            'message' => 'Không tìm thấy thông tin xác thực.'
        ], 401);
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
