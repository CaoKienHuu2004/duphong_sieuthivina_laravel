<?php

namespace App\Http\Controllers\client\api;

use App\Http\Controllers\Controller;
use App\Models\ChitietdonhangModel;
use App\Models\DanhgiaModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Models\DonhangModel;
use App\Models\BientheModel;
use App\Models\GiohangModel;
use App\Models\ThongbaoModel;
use Illuminate\Support\Facades\Validator;
use App\Http\Resources\SanphamResource;
use Illuminate\Support\Facades\Mail;
use App\Mail\HuydonhangMail;
use Illuminate\Support\Facades\Log;


class DonhangController extends Controller
{

    /**
     * 4. LẤY DANH SÁCH ĐƠN HÀNG (Kèm bộ lọc)
     * Thay thế cho: loadDonHangs() bên Livewire
     * Method: GET
     * Params: ?status=Chờ xác nhận & payment_status=Tất cả & page=1
     */
    public function index(Request $request)
    {
        $user = Auth::user();
        $status = $request->input('status', 'Tất cả'); // Mặc định lấy tất cả nếu không truyền
        $paymentStatus = $request->input('payment_status', 'Tất cả');

        $query = DonhangModel::where('id_nguoidung', $user->id);

        // 1. Lọc theo trạng thái Đơn hàng
        if ($status !== 'Tất cả') {
            $query->where('trangthai', $status);
        }

        // 2. Lọc theo trạng thái Thanh toán (Logic giống Livewire)
        if ($paymentStatus !== 'Tất cả') {
            // Nếu lọc thanh toán, thường đi kèm status đơn hàng cụ thể hoặc logic riêng
            $query->where('trangthaithanhtoan', $paymentStatus);
        }

        // 3. Eager Loading (Nạp sẵn dữ liệu quan hệ)
        $donhangs = $query->with([
                'chitietdonhang.bienthe.sanpham', // Lấy thông tin sản phẩm
                'chitietdonhang.bienthe.loaibienthe', // Lấy màu/size
                'phivanchuyen'
            ])
            ->orderBy('created_at', 'desc')
            ->paginate(10); // API nên phân trang (10 đơn/trang)

        return response()->json([
            'status' => 200,
            'message' => 'Lấy danh sách đơn hàng thành công',
            'data' => $donhangs
        ]);
    }

    /**
     * 5. LẤY SỐ LƯỢNG ĐƠN HÀNG THEO TRẠNG THÁI (Để hiển thị Badge trên Tab)
     * Thay thế cho: loadFilterCounts() bên Livewire
     * Method: GET
     */
    public function getOrderCounts()
    {
        $userId = Auth::id();

        // 1. Đếm theo trạng thái xử lý
        $processingCounts = DonhangModel::where('id_nguoidung', $userId)
            ->selectRaw('trangthai, count(*) as count')
            ->groupBy('trangthai')
            ->pluck('count', 'trangthai')
            ->toArray();

        // 2. Đếm trạng thái "Chờ thanh toán" riêng (như logic Livewire của bạn)
        $pendingPaymentCount = DonhangModel::where('id_nguoidung', $userId)
            ->where('trangthaithanhtoan', 'Chờ thanh toán')
            ->count();

        // Merge lại để trả về FE
        $result = $processingCounts;
        $result['ChoThanhToan'] = $pendingPaymentCount; // Đặt key không dấu cho dễ gọi ở FE

        return response()->json([
            'status' => 200,
            'data' => $result
        ]);
    }

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
            // 'ly_do' => 'nullable|string|max:255'
        ]);

        $user = Auth::user();
        $donhang = DonhangModel::with('nguoidung')->where('madon', $request->madon)
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
                "Mã đơn {$donhang->madon} đã được hủy.",
                "#", // Link FE (nếu có)
                'Đơn hàng'
            );

            DB::commit();

            $nguoidung = Auth::user();
            // GỬI MAIL
            try {
                
                // Nạp chi tiết để hiển thị trong mail
                $donhang->load('chitietdonhang'); 
                
                // Lấy email người đặt (hoặc người nhận tùy logic)
                $emailNhan = $nguoidung->email; // Đảm bảo lấy đúng email

                Mail::to($emailNhan)->send(new HuydonhangMail($donhang));
                
            } catch (\Exception $e) {
                Log::error("Gửi mail hủy đơn thất bại: " . $e->getMessage());
            }

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

    /**
     * 6. MUA LẠI (Re-order)
     * Logic: Copy sản phẩm từ đơn cũ bỏ vào giỏ hàng
     * Method: POST
     */
    public function reOrder(Request $request)
    {
        // 1. Validate dữ liệu đầu vào
        $validator = Validator::make($request->all(), [
            'items' => 'required|array',
            'items.*.id_bienthe' => 'required|exists:bienthe,id',
            'items.*.soluong' => 'required|integer|min:1',
        ], [
            'items.required' => 'Không có sản phẩm nào để mua lại.',
            'items.*.exists' => 'Sản phẩm không tồn tại hoặc đã ngừng kinh doanh.',
        ]);

        if ($validator->fails()) {
            return response()->json(['status' => 422, 'errors' => $validator->errors()], 422);
        }

        $user = Auth::user();
        $itemsToAdd = $request->items;
        
        $addedCount = 0;
        $failedItems = []; // Mảng chứa các món bị lỗi (hết hàng)

        DB::beginTransaction();
        try {
            foreach ($itemsToAdd as $item) {
                $idBienthe = $item['id_bienthe'];
                $soLuongMuonMua = $item['soluong'];

                // 2. Load Biến thể kèm Sản phẩm cha để ném vào Resource
                $bienthe = BientheModel::with('sanpham')->find($idBienthe);

                // Kiểm tra dữ liệu sản phẩm
                if (!$bienthe || !$bienthe->sanpham) {
                    $failedItems[] = "Sản phẩm biến thể ID $idBienthe bị lỗi dữ liệu.";
                    continue;
                }

                // 3. Kiểm tra Tồn kho
                if ($bienthe->soluong < $soLuongMuonMua) {
                    $tenSp = $bienthe->sanpham->ten;
                    $failedItems[] = "$tenSp chỉ còn {$bienthe->soluong} sản phẩm (không đủ $soLuongMuonMua).";
                    continue; 
                }

                // ====================================================
                // 4. [QUAN TRỌNG] LẤY GIÁ TỪ SANPHAM RESOURCE
                // ====================================================
                
                // B4.1: Khởi tạo Resource và Resolve ra mảng dữ liệu

                // B4.2: Lấy giá từ mảng data vừa resolve
                // BÀ CHÚ Ý: Mở file SanphamResource.php xem key giá tên là gì rồi sửa dòng dưới nhé
                // Tui đang để mặc định các trường hợp phổ biến:
                $giaGoc = $bienthe->giagoc ?? 0;
                $phanTramGiam = $bienthe->sanpham->giamgia ?? 0;
                $giadaGiam = $giaGoc * (1 - ($phanTramGiam / 100));

                $donGia = $giadaGiam;
                // Tính thành tiền
                $thanhTienMoi = $donGia * $soLuongMuonMua;

                // ====================================================
                // 5. THÊM VÀO GIỎ HÀNG (CẬP NHẬT HOẶC TẠO MỚI)
                // ====================================================
                $cartItem = GiohangModel::where('id_nguoidung', $user->id)
                                        ->where('id_bienthe', $idBienthe)
                                        ->first();

                if ($cartItem) {
                    // TRƯỜNG HỢP 1: Đã có trong giỏ -> Cộng dồn số lượng & Tính lại tiền
                    $newQty = $cartItem->soluong + $soLuongMuonMua;
                    
                    // Check lại tồn kho tổng (Tùy chọn, nên có cho chặt chẽ)
                    if ($newQty > $bienthe->soluong) {
                         $tenSp = $bienthe->sanpham->ten_sanpham;
                         $failedItems[] = "Không thể thêm $tenSp. Tổng số lượng trong giỏ ($newQty) vượt quá tồn kho.";
                         continue;
                    }

                    $cartItem->soluong = $newQty;
                    $cartItem->thanhtien = $newQty * $donGia; // Cập nhật thành tiền mới
                    $cartItem->save();

                } else {
                    // TRƯỜNG HỢP 2: Chưa có -> Tạo mới
                    GiohangModel::create([
                        'id_nguoidung' => $user->id,
                        'id_bienthe' => $idBienthe,
                        'soluong' => $soLuongMuonMua,
                        'thanhtien' => $thanhTienMoi, // Lưu thành tiền
                        'trangthai' => 'Hiển thị'     // Mặc định hiển thị
                    ]);
                }

                $addedCount++;
            }

            DB::commit();

            // 6. Trả về kết quả
            if ($addedCount > 0) {
                return response()->json([
                    'status' => 200,
                    'message' => "Đã thêm thành công $addedCount sản phẩm vào giỏ hàng.",
                    'warnings' => $failedItems // Trả về danh sách lỗi (nếu có món nào hết hàng)
                ]);
            } else {
                return response()->json([
                    'status' => 400,
                    'message' => 'Không thêm được sản phẩm nào (Có thể do hết hàng).',
                    'errors' => $failedItems
                ], 400);
            }

        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['status' => 500, 'message' => 'Lỗi hệ thống: ' . $e->getMessage()], 500);
        }
    }


}