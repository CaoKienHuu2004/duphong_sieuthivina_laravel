<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\NguoidungModel; // Hoặc App\Models\NguoiDungModel tùy project bạn
use Illuminate\Http\Request;
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

        // Tìm kiếm theo Tên, Email hoặc Số điện thoại
        if ($request->filled('keyword')) {
            $keyword = $request->keyword;
            $query->where(function($q) use ($keyword) {
                $q->where('name', 'like', "%{$keyword}%")
                  ->orWhere('email', 'like', "%{$keyword}%")
                  ->orWhere('phone', 'like', "%{$keyword}%");
            });
        }

        // Lọc theo trạng thái (nếu cần)
        if ($request->filled('trangthai')) {
            $query->where('trangthai', $request->trangthai);
        }

        // Sắp xếp mới nhất trước
        $users = $query->orderByDesc('id')->paginate(10);

        return view('admin.nguoidung', compact('users'));
    }

    /**
     * 2. XEM CHI TIẾT & FORM CẬP NHẬT TRẠNG THÁI (READ DETAIL)
     * Không cho phép sửa thông tin cá nhân, chỉ hiện để xem
     */
    public function edit($id)
    {
        $user = NguoidungModel::findOrFail($id);
        return view('admin.nguoidung.edit', compact('user'));
    }

    /**
     * 3. CẬP NHẬT TRẠNG THÁI (UPDATE STATUS ONLY)
     */
    public function update(Request $request, $id)
    {
        $user = NguoidungModel::findOrFail($id);

        // Validate: Chỉ bắt buộc nhập trạng thái
        $request->validate([
            'trangthai' => 'required|in:Hoạt động,Bị khóa', // Hoặc 1,0 tùy database của bạn
        ], [
            'trangthai.required' => 'Vui lòng chọn trạng thái.',
            'trangthai.in' => 'Trạng thái không hợp lệ.',
        ]);

        DB::beginTransaction();
        try {
            // Chỉ cập nhật duy nhất cột trạng thái
            $user->update([
                'trangthai' => $request->trangthai
            ]);

            DB::commit();
            return redirect()->route('quan-tri-vien.danh-sach-nguoi-dung')
                             ->with('success', 'Cập nhật trạng thái tài khoản thành công!');

        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Lỗi: ' . $e->getMessage());
        }
    }

    // KHÔNG CÓ CREATE, KHÔNG CÓ DESTROY
}