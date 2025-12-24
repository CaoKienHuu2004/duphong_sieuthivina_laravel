<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\ThongBaoModel;
use App\Models\NguoidungModel; // Hoặc NguoidungModel tùy project của bạn
use Illuminate\Support\Facades\DB;

class ThongbaoController extends Controller
{
    // 1. FORM TẠO THÔNG BÁO
    public function create()
    {
        return view('admin.thongbao');
    }

    // 2. XỬ LÝ GỬI THÔNG BÁO (BROADCAST)
    public function store(Request $request)
    {
        $request->validate([
            'tieude'  => 'required|string|max:255',
            'loai'    => 'required',
            'noidung' => 'required',
            'lienket' => 'required',
        ]);

        DB::beginTransaction();
        try {
            // Lấy danh sách người dùng đang hoạt động để gửi
            // (Bạn có thể lọc thêm: chỉ gửi cho Khách hàng, bỏ qua Admin nếu muốn)
            $users = NguoidungModel::where('trangthai', 'Hoạt động')->get();

            if ($users->count() == 0) {
                return redirect()->back()->with('error', 'Không tìm thấy người dùng nào để gửi thông báo.');
            }

            // Chuẩn bị dữ liệu để Insert hàng loạt (Nhanh hơn insert từng dòng)
            $dataInsert = [];
            $now = now(); // Lấy thời gian hiện tại

            foreach ($users as $user) {
                $dataInsert[] = [
                    'id_nguoidung' => $user->id,
                    'tieude'       => $request->tieude,
                    'noidung'      => $request->noidung,
                    'loai'         => $request->loai,     // VD: 'KhuyenMai', 'HeThong', 'QuaTang'
                    'trangthai'    => 0,                  // 0: Chưa xem
                    'created_at'   => $now,
                    'updated_at'   => $now,
                ];
            }

            // Insert hàng loạt (Chunk để tránh lỗi nếu quá nhiều user)
            foreach (array_chunk($dataInsert, 500) as $chunk) {
                ThongBaoModel::insert($chunk);
            }

            DB::commit();
            return redirect()->back()->with('success', 'Đã gửi thông báo đến ' . count($users) . ' người dùng thành công!');

        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->withInput()->with('error', 'Lỗi gửi thông báo: ' . $e->getMessage());
        }
    }
}