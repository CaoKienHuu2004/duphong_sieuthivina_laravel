<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\NguoidungModel; // Hoặc App\Models\NguoiDungModel tùy project bạn
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Auth as FacadesAuth;
use Illuminate\Support\Facades\DB;

class NguoiDungController extends Controller
{
    /**
     * 1. DANH SÁCH NGƯỜI DÙNG (READ LIST)
     * Có tích hợp tìm kiếm và phân trang
     */
    public function index(Request $request)
    {
        $query = NguoidungModel::query();

        // Sắp xếp mới nhất trước
        $users = $query->orderByDesc('id')->get();

        return view('admin.nguoidung', compact('users'));
    }

    public function actionKhoataikhoan($id)
    {
        try {
            // 1. Tìm người dùng
            $user = NguoidungModel::findOrFail($id);

            // 2. Kiểm tra và đảo ngược trạng thái
            // Lưu ý: Chuỗi 'Hoạt động' và 'Tạm khóa' phải khớp chính xác với Database của bạn
            if ($user->trangthai == 'Hoạt động') {
                $user->trangthai = 'Tạm khóa'; // Chuyển sang khóa
                $message = 'Đã khóa tài khoản [' . $user->username . '] thành công!';
            } else {
                $user->trangthai = 'Hoạt động'; // Chuyển sang mở
                $message = 'Đã mở khóa tài khoản [' . $user->username . '] thành công!';
            }

            // 3. Lưu lại
            $user->save();

            // 4. Quay lại trang trước và báo thành công
            return redirect()->back()->with('success', $message);

        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Lỗi: Không tìm thấy người dùng hoặc có lỗi hệ thống.');
        }
    }

    public function actionVaitro($id)
    {
        try {
            // 1. Tìm người dùng cần sửa
            $user = NguoidungModel::findOrFail($id);

            // --- RÀNG BUỘC 1: Không cho phép tự thay đổi quyền của chính mình ---
            if (Auth::user()->id == $user->id) {
                return redirect()->back()->with('error', 'Bạn không thể tự thay đổi vai trò của chính mình!');
            }

            // Định nghĩa giá trị vai trò (Sửa lại số này nếu DB của bạn khác)
            $roleAdmin = 'admin'; 
            $roleClient = 'client'; 

            // 2. Kiểm tra logic chuyển đổi
            if ($user->vaitro == $roleAdmin) {
                // A. Trường hợp đang là ADMIN -> Muốn chuyển xuống CLIENT
                
                // --- RÀNG BUỘC 2: Kiểm tra xem còn bao nhiêu admin ---
                $countAdmin = NguoidungModel::where('vaitro', $roleAdmin)->count();
                
                if ($countAdmin <= 1) {
                    return redirect()->back()->with('error', 'Thao tác bị chặn: Hệ thống bắt buộc phải có ít nhất 1 Quản trị viên!');
                }

                $user->vaitro = $roleClient;
                $message = 'Đã hủy quyền Quản trị của [' . ($user->username ?? $user->name) . '] thành công!';

            } else {
                // B. Trường hợp đang là CLIENT -> Muốn chuyển lên ADMIN
                $user->vaitro = $roleAdmin;
                $message = 'Đã cấp quyền Quản trị cho [' . ($user->username ?? $user->name) . '] thành công!';
            }

            // 3. Lưu lại
            $user->save();

            return redirect()->back()->with('success', $message);

        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Lỗi: Không tìm thấy người dùng hoặc lỗi hệ thống.');
        }
    }
}