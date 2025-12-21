<?php

namespace App\Http\Controllers\client\api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\ThongbaoModel;

class ThongbaoController extends Controller
{
    /**
     * 1. LẤY DANH SÁCH THÔNG BÁO (CÓ LỌC)
     * Method: GET
     * Params: ?loai=donhang (Optional)
     */
    public function index(Request $request)
    {
        $userId = Auth::id();
        $loai = $request->input('loaithongbao'); // Lấy tham số 'loai' từ URL

        // Khởi tạo Query
        $query = ThongbaoModel::where('id_nguoidung', $userId);

        // [MỚI] Nếu có truyền loại -> Thêm điều kiện lọc
        // Ví dụ: FE gửi ?loai=donhang -> Chỉ lấy thông báo đơn hàng
        if ($loai && $loai !== 'all') {
            $query->where('loaithongbao', $loai);
        }

        // Lấy danh sách phân trang
        $notifications = $query->orderBy('created_at', 'desc')
                               ->paginate(10);

        // Đếm số lượng chưa đọc (Tổng thể, không phụ thuộc vào lọc để hiện badge luôn đúng)
        $unreadCount = ThongbaoModel::where('id_nguoidung', $userId)
            ->where('trangthai', 'Chưa đọc')
            ->count();

        return response()->json([
            'status' => 200,
            'message' => 'Lấy danh sách thông báo thành công',
            'unread_count' => $unreadCount,
            'current_filter' => $loai ?? 'all', // Trả về để FE biết đang lọc cái gì
            'data' => $notifications
        ]);
    }

    // ... (Các hàm markAsRead, markAllRead, destroy giữ nguyên như cũ) ...
    
    /**
     * 2. ĐÁNH DẤU ĐÃ ĐỌC (GIỮ NGUYÊN)
     */
    public function markAsRead(Request $request)
    {
        $userId = Auth::id();
        $idThongBao = $request->input('id');

        $thongbao = ThongbaoModel::where('id', $idThongBao)
            ->where('id_nguoidung', $userId)
            ->first();

        if (!$thongbao) {
            return response()->json(['status' => 404, 'message' => 'Thông báo không tồn tại'], 404);
        }

        $thongbao->trangthai = 'Đã đọc';
        $thongbao->save();

        return response()->json([
            'status' => 200,
            'message' => 'Đã đánh dấu là đã đọc',
            'id' => $thongbao->id
        ]);
    }

    /**
     * 3. ĐÁNH DẤU TẤT CẢ LÀ ĐÃ ĐỌC (GIỮ NGUYÊN)
     */
    public function markAllRead()
    {
        $userId = Auth::id();
        ThongbaoModel::where('id_nguoidung', $userId)->where('trangthai', 'Chưa đọc')->update(['trangthai' => 'Đã đọc']);
        return response()->json(['status' => 200, 'message' => 'Đã đánh dấu tất cả là đã đọc']);
    }

    /**
     * 4. XÓA THÔNG BÁO (GIỮ NGUYÊN)
     */
    public function destroy($id)
    {
        $userId = Auth::id();
        $deleted = ThongbaoModel::where('id', $id)->where('id_nguoidung', $userId)->delete();
        return $deleted 
            ? response()->json(['status' => 200, 'message' => 'Đã xóa thông báo']) 
            : response()->json(['status' => 404, 'message' => 'Lỗi khi xóa'], 404);
    }
}