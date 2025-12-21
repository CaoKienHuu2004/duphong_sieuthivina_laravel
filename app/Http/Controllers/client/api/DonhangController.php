<?php

namespace App\Http\Controllers\client\api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Models\DonhangModel;
use App\Models\BientheModel;
use App\Models\ThongbaoModel;

class DonhangController extends Controller
{
    /**
     * 1. CHI TIẾT ĐƠN HÀNG
     * Yêu cầu: Đăng nhập + Đơn hàng đó phải của người dùng đó
     */
    public function getOrderDetail($madon)
    {
        $user = Auth::user();

        // Tìm đơn hàng theo mã đơn và phải thuộc về user đang đăng nhập
        $donhang = DonhangModel::with([
                'chitietdonhang.bienthe.sanpham.hinhanhsanpham', // Load sâu để lấy ảnh/tên sp
                'chitietdonhang.bienthe.loaibienthe', // Load tên biến thể (Màu/Size)
                'phuongthuc', 
                'phivanchuyen', 
                'magiamgia'
            ])
            ->where('madon', $madon)
            ->where('id_nguoidung', $user->id)
            ->first();

        if (!$donhang) {
            return response()->json([
                'status' => 404, 
                'message' => 'Đơn hàng không tồn tại hoặc không thuộc về bạn.'
            ], 404);
        }

        return response()->json([
            'status' => 200,
            'message' => 'Lấy chi tiết đơn hàng thành công',
            'data' => $donhang
        ]);
    }

    /**
     * 2. HỦY ĐƠN HÀNG
     * Logic bổ sung: Khi hủy phải cộng lại số lượng tồn kho cho sản phẩm
     */
    public function cancelOrder(Request $request)
    {
        $request->validate([
            'madon' => 'required|exists:donhang,madon',
            'ly_do' => 'nullable|string|max:255'
        ]);

        $user = Auth::user();
        $donhang = DonhangModel::where('madon', $request->madon)
                                ->where('id_nguoidung', $user->id)
                                ->first();

        if (!$donhang) {
            return response()->json(['status' => 404, 'message' => 'Đơn hàng không tìm thấy.'], 404);
        }

        // Chỉ cho phép hủy khi mới đặt hoặc chờ thanh toán
        // Nếu đã "Đang giao" hoặc "Đã giao" thì không được hủy
        $allowStatus = ['Chờ xác nhận', 'Chờ thanh toán'];
        
        if (!in_array($donhang->trangthai, $allowStatus)) {
            return response()->json([
                'status' => 400, 
                'message' => 'Đơn hàng đang trong trạng thái xử lý hoặc đang giao, không thể hủy.'
            ], 400);
        }

        DB::beginTransaction();
        try {
            // 1. Cập nhật trạng thái
            $donhang->trangthai = 'Đã hủy đơn';// Lưu lý do nếu có
            $donhang->trangthaithanhtoan = 'Hủy thanh toán';// Lưu lý do nếu có
            $donhang->save();

            // 2. HOÀN TRẢ TỒN KHO (Quan trọng)
            foreach ($donhang->chitietdonhang as $chitiet) {
                $bienthe = BientheModel::find($chitiet->id_bienthe);
                if ($bienthe) {
                    $bienthe->soluong += $chitiet->soluong; // Cộng lại kho
                    $bienthe->luotban -= $chitiet->soluong; // Trừ đi lượt bán ảo
                    
                    // Nếu là hàng tặng (giá = 0), trả lại quỹ lượt tặng
                    if ($chitiet->dongia == 0) {
                         $bienthe->luottang += $chitiet->soluong;
                    }
                    
                    $bienthe->save();
                }
            }

            // 3. Tạo thông báo
            ThongbaoModel::khoitaothongbao(
                $user->id,
                "Đơn hàng đã bị hủy",
                "Mã đơn {$donhang->madon} đã được hủy thành công.",
                "#", // Link FE (nếu có)
                'Đơn hàng'
            );

            DB::commit();

            return response()->json([
                'status' => 200, 
                'message' => 'Đơn hàng đã được hủy thành công và hoàn tồn kho.'
            ]);

        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['status' => 500, 'message' => 'Lỗi hệ thống: ' . $e->getMessage()], 500);
        }
    }

    /**
     * 3. TRA CỨU ĐƠN HÀNG (Yêu cầu Login + Nhập Mã đơn + SĐT nhận hàng)
     * Đây là lớp bảo mật cấp 2: Dù đã login nhưng phải nhập đúng SĐT nhận hàng của đơn đó mới cho xem
     */
    public function trackOrder(Request $request)
    {
        $request->validate([
            'madon' => 'required|string',
            'sodienthoai' => 'required|numeric|digits_between:9,11',
        ], [
            'madon.required' => 'Vui lòng nhập mã đơn hàng.',
            'sodienthoai.required' => 'Vui lòng nhập số điện thoại người nhận.',
        ]);

        $user = Auth::user();

        // Tìm đơn hàng khớp Mã đơn + SĐT trong đơn hàng + Thuộc về User này
        $donhang = DonhangModel::with(['chitietdonhang.bienthe.sanpham', 'phuongthuc', 'phivanchuyen'])
            ->where('madon', $request->madon)
            ->where('sodienthoai', $request->sodienthoai) // Check SĐT trong đơn (người nhận)
            ->first();

        if ($donhang) {
            return response()->json([
                'status' => 200,
                'message' => 'Tra cứu thành công',
                'data' => $donhang
            ]);
        } else {
            return response()->json([
                'status' => 404,
                'message' => 'Không tìm thấy đơn hàng hoặc thông tin số điện thoại không khớp.'
            ], 404);
        }
    }
}