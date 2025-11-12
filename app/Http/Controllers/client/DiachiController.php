<?php

namespace App\Http\Controllers\client;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\DiachinguoidungModel;
use Illuminate\Support\Facades\DB;

class DiachiController extends Controller
{
    /**
     * Hiển thị danh sách địa chỉ của người dùng để chọn.
     */
    public function index()
    {
        // $diachis = Auth::user()->diachi()->orderBy('trangthai', 'desc')->get();
        $diachis = DiachinguoidungModel::where('id_nguoidung', Auth::id())->orderBy('trangthai', 'asc')->get();
        
        return view('client.nguoidung.sodiachi', compact('diachis'));
    }

    /**
     * Xử lý cập nhật địa chỉ được chọn thành 'Mặc định'.
     */
    public function updateDefaultAddress(Request $request)
    {
        $request->validate([
            'id_diachi' => 'required|exists:diachi_nguoidung,id',
        ]);

        $id_diachi_moi = $request->id_diachi;
        $id_nguoidung = Auth::id();

        DB::beginTransaction();
        try {
            // 1. Reset tất cả địa chỉ của người dùng này về trạng thái 'Bình thường' (ví dụ)
            DiachinguoidungModel::where('id_nguoidung', $id_nguoidung)
                                ->where('trangthai', 'Mặc định')
                                ->update(['trangthai' => 'Khác']);

            // 2. Đặt địa chỉ mới được chọn thành 'Mặc định'
            $diachi_moi = DiachinguoidungModel::find($id_diachi_moi);
            if ($diachi_moi && $diachi_moi->id_nguoidung == $id_nguoidung) {
                $diachi_moi->trangthai = 'Mặc định';
                $diachi_moi->save();
            } else {
                 DB::rollBack();
                 return redirect()->back()->with('error', 'Địa chỉ không hợp lệ.');
            }

            DB::commit();
            return redirect()->route('thanh-toan')->with('success', 'Đã cập nhật địa chỉ mặc định thành công.');

        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Lỗi khi cập nhật địa chỉ: ' . $e->getMessage());
        }
    }
}