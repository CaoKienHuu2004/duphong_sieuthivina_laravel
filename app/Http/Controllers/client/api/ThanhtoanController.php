<?php

namespace App\Http\Controllers\client\api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Carbon\Carbon;
use Illuminate\Support\Str;
use App\Models\DonhangModel;
use App\Models\ChitietdonhangModel;
use App\Models\DiachinguoidungModel;
use App\Models\GiohangModel;
use App\Models\PhuongthucModel;
use App\Models\PhivanchuyenModel;
use App\Models\BientheModel;
use App\Models\ThongbaoModel;
use App\Mail\DathangthanhcongMail;
use Illuminate\Support\Facades\Mail;

class ThanhtoanController extends Controller
{
    /**
     * 1. ĐẶT HÀNG & TẠO LINK THANH TOÁN (COD hoặc VNPAY)
     */
    public function placeOrder(Request $request)
    {
        $user = Auth::user(); // Lấy user từ Token (Sanctum)

        // Validate dữ liệu đầu vào
        $request->validate([
            'id_phuongthuc' => 'required|exists:phuongthuc,id',
            'voucher_code' => 'nullable|string'
        ], [
            'id_phuongthuc.required' => 'Vui lòng chọn phương thức thanh toán.',
            'id_phuongthuc.exists' => 'Phương thức thanh toán không hợp lệ.'
        ]);

        DB::beginTransaction();
        try {
            // --- BƯỚC 1: LẤY DỮ LIỆU GIỎ HÀNG TỪ CONTROLLER KHÁC ---
            // Tái sử dụng logic tính toán (Quà tặng, Voucher, Tổng tiền) của ApiGiohangController
            $cartResponse = app(\App\Http\Controllers\client\api\GiohangController::class)->getCartDetails($request);
            $cartData = $cartResponse->getData()->data;

            if (empty($cartData->items)) {
                throw new \Exception('Giỏ hàng của bạn đang trống.');
            }

            // --- BƯỚC 2: LẤY ĐỊA CHỈ MẶC ĐỊNH ---
            $diachi = DiachinguoidungModel::where('id_nguoidung', $user->id)
                ->where('trangthai', 'Mặc định')
                ->first();

            if (!$diachi) {
                // Fallback: Nếu không có mặc định, lấy địa chỉ đầu tiên tìm thấy
                $diachi = DiachinguoidungModel::where('id_nguoidung', $user->id)->first();
            }

            if (!$diachi) {
                throw new \Exception('Vui lòng thêm địa chỉ nhận hàng trước khi thanh toán.');
            }

            // --- BƯỚC 3: TÍNH TOÁN CHI PHÍ ---
            $phuongthuc = PhuongthucModel::find($request->id_phuongthuc);
            $shipping = $this->calculateShippingFee($diachi->tinhthanh);

            // Tổng thanh toán = Tổng giá trị hàng (sau khi trừ voucher) + Phí ship
            $tongThanhToan = $cartData->summary->tonggiatri + $shipping['phi'];

            // --- BƯỚC 4: TẠO ĐƠN HÀNG (DonhangModel) ---
            $order = new DonhangModel();
            $order->id_nguoidung = $user->id;
            $order->id_phuongthuc = $phuongthuc->id;
            $order->id_diachinguoidung = $diachi->id;
            $order->id_phivanchuyen = $shipping['model']->id ?? null;
            $order->id_magiamgia = $cartData->summary->voucher_info->id ?? null;

            // Thông tin giao hàng
            $order->madon = 'TEMP'; // Tạm thời để TEMP, update sau khi có ID
            $order->nguoinhan = $diachi->hoten;
            $order->diachinhan = $diachi->diachi;
            $order->khuvucgiao = $diachi->tinhthanh .', ';
            $order->sodienthoai = $diachi->sodienthoai;

            // Thông tin tài chính
            $order->hinhthucvanchuyen = $shipping['model']->ten ?? 'Tiêu chuẩn';
            $order->phigiaohang = $shipping['phi'];
            $order->hinhthucthanhtoan = $phuongthuc->ten;
            $order->mavoucher = $cartData->summary->voucher_info->magiamgia ?? null;
            $order->giagiam = $cartData->summary->giamgia_voucher;
            $order->tamtinh = $cartData->summary->tamtinh;
            $order->thanhtien = $tongThanhToan;

            // Trạng thái
            $order->trangthai = 'Chờ xác nhận';
            $order->trangthaithanhtoan = ($phuongthuc->maphuongthuc == 'COD') ? 'Thanh toán khi nhận hàng' : 'Chờ thanh toán';

            $order->save();

            // Cập nhật mã đơn hàng chuẩn: STV + NămThángNgày + ID (Ví dụ: STV251221001)
            $order->madon = 'STV' . Carbon::now()->format('ymd') . $order->id;
            $order->save();

            // --- BƯỚC 5: LƯU CHI TIẾT & TRỪ TỒN KHO ---
            foreach ($cartData->items as $item) {
                // Lưu chi tiết
                ChitietdonhangModel::create([
                    'id_bienthe' => $item->id_bienthe,
                    'id_donhang' => $order->id,
                    'tensanpham' => $item->bienthe->sanpham->ten,
                    'tenbienthe' => $item->bienthe->loaibienthe->ten ?? '',
                    'soluong' => $item->soluong,
                    // Nếu là quà tặng (thanhtien=0) thì đơn giá là 0, ngược lại tính đơn giá
                    'dongia' => ($item->thanhtien > 0) ? ($item->thanhtien / $item->soluong) : 0,
                ]);

                // Trừ tồn kho
                $bienthe = BientheModel::find($item->id_bienthe);
                if ($bienthe->soluong < $item->soluong) {
                    throw new \Exception("Sản phẩm '{$bienthe->sanpham->ten}' không đủ số lượng tồn kho.");
                }

                $bienthe->soluong -= $item->soluong; // Luôn trừ số lượng tồn
                $bienthe->luotban += $item->soluong; // Tăng lượt bán

                // Nếu là quà tặng, trừ thêm vào quỹ "luottang" (nếu bạn quản lý quỹ quà)
                if ($item->thanhtien == 0) {
                    $bienthe->luottang -= $item->soluong;
                }

                $bienthe->save();
            }

            // --- BƯỚC 6: DỌN DẸP GIỎ HÀNG ---
            GiohangModel::where('id_nguoidung', $user->id)->delete();

            DB::commit();

            // ================================================================
            // [MỚI] GỬI MAIL XÁC NHẬN ĐƠN HÀNG (SAU KHI DB COMMIT THÀNH CÔNG)
            // ================================================================
            try {
                // Nạp quan hệ chi tiết đơn hàng để hiển thị trong Mail View
                $order->load('chitietdonhang');
                
                // Gửi mail đến email của user đang đăng nhập
                Mail::to($user->email)->send(new DathangthanhcongMail($order));
            } catch (\Exception $e) {
                // Log lỗi mail nhưng KHÔNG return lỗi (để quy trình đặt hàng vẫn thành công)
                Log::error("Gửi mail đơn hàng {$order->madon} thất bại: " . $e->getMessage());
            }
            // ================================================================

            try {
                        ThongbaoModel::khoitaothongbao(
                            $order->id_nguoidung,
                            "Bạn đã đặt hàng thành công !",
                            "Mã đơn {$order->madon} của bạn, vui lòng kiểm tra đơn hàng của bạn.",
                            "#",
                            "Đơn hàng"
                        );
                    } catch (\Exception $e) {
                        // Log lỗi thông báo nhưng không chặn quy trình thanh toán
                        \Log::error('Lỗi tạo thông báo: ' . $e->getMessage());
                    }

            // --- BƯỚC 7: XỬ LÝ THANH TOÁN ---
            $paymentUrl = null;

            // Nếu phương thức là VNPAY, tạo link thanh toán
            if ($phuongthuc->maphuongthuc == 'QRCODE') {
                $paymentUrl = $this->createVnpayUrl($order);
            }

            // --- BƯỚC 8: TRẢ VỀ KẾT QUẢ ---
            return response()->json([
                'status' => 200,
                'message' => 'Đặt hàng thành công!',
                'data' => [
                    'madon' => $order->madon,
                    'tong_tien' => $order->thanhtien,
                    'payment_method' => $phuongthuc->maphuongthuc,
                    'payment_url' => $paymentUrl // Nếu COD thì null, nếu VNPAY thì là link
                ]
            ]);
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error("Place Order Error: " . $e->getMessage());
            return response()->json([
                'status' => 500,
                'message' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * 2. API XÁC THỰC KẾT QUẢ VNPAY (FE gọi vào sau khi khách quay lại)
     */
    public function vnpayReturn(Request $request)
    {
        // 1. Lấy dữ liệu
        $inputData = $request->all();

        if (!isset($inputData['vnp_SecureHash'])) {
            return response()->json(['status' => 400, 'message' => 'Dữ liệu không hợp lệ (Thiếu hash)']);
        }

        $vnp_SecureHash = $inputData['vnp_SecureHash'];
        unset($inputData['vnp_SecureHash']);
        ksort($inputData);
        $i = 0;
        $hashData = "";
        foreach ($inputData as $key => $value) {
            if ($i == 1) {
                $hashData .= '&' . urlencode($key) . "=" . urlencode($value);
            } else {
                $hashData .= urlencode($key) . "=" . urlencode($value);
                $i = 1;
            }
        }

        $vnp_HashSecret = env('VNP_HASH_SECRET');
        $secureHash = hash_hmac('sha512', $hashData, $vnp_HashSecret);

        // 2. Kiểm tra chữ ký
        if ($secureHash == $vnp_SecureHash) {
            $madon = $inputData['vnp_TxnRef'];
            $order = DonhangModel::where('madon', $madon)->first();

            if (!$order) {
                return response()->json(['status' => 404, 'message' => 'Đơn hàng không tồn tại']);
            }

            // 3. Kiểm tra Response Code (Dùng chuỗi '00')
            if ($inputData['vnp_ResponseCode'] == '00') {

                // --- SỬA LỖI Ở ĐÂY ---
                // Kiểm tra trạng thái hiện tại phải KHÁC 'Đã thanh toán'
                // Thay vì liệt kê các trạng thái cũ, ta chỉ cần check nó chưa thanh toán là được
                if ($order->trangthaithanhtoan != 'Đã thanh toán') {

                    // Thực hiện Update
                    $order->update(['trangthaithanhtoan' => 'Đã thanh toán']);

                    // Gửi thông báo
                    try {
                        ThongbaoModel::khoitaothongbao(
                            $order->id_nguoidung,
                            "Thanh toán thành công",
                            "Đơn hàng {$order->madon} đã được thanh toán qua VNPay.",
                            "#",
                            "Đơn hàng"
                        );
                    } catch (\Exception $e) {
                        // Log lỗi thông báo nhưng không chặn quy trình thanh toán
                        \Log::error('Lỗi tạo thông báo: ' . $e->getMessage());
                    }

                    // Log để chắc chắn code đã chạy vào đây
                    \Log::info("Đã cập nhật đơn hàng $madon thành công.");
                }

                // Trả về kết quả
                return response()->json([
                    'status' => 200,
                    'message' => 'Giao dịch thành công',
                    'data' => [
                        'madon' => $order->madon,
                        'amount' => $inputData['vnp_Amount'] / 100
                    ]
                ]);
            } else {
                // Trường hợp thất bại
                return response()->json([
                    'status' => 400,
                    'message' => 'Giao dịch thất bại',
                    'error_code' => $inputData['vnp_ResponseCode']
                ]);
            }
        } else {
            return response()->json(['status' => 97, 'message' => 'Chữ ký không hợp lệ']);
        }
    }

    // --- CÁC HÀM PRIVATE HELPER ---

    /**
     * Tạo URL thanh toán chuyển hướng sang VNPay
     */
    private function createVnpayUrl($order)
    {
        $vnp_Url = env('VNP_URL');
        $vnp_Returnurl = env('VNP_RETURN_URL'); // Link Frontend đón khách
        $vnp_TmnCode = env('VNP_TMN_CODE');
        $vnp_HashSecret = env('VNP_HASH_SECRET');

        $vnp_TxnRef = $order->madon;
        $vnp_OrderInfo = "Thanh toan don hang " . $order->madon;
        $vnp_OrderType = "billpayment";
        $vnp_Amount = $order->thanhtien * 100; // VNPay tính tiền = VND * 100
        $vnp_Locale = "vn";
        $vnp_IpAddr = request()->ip();
        $vnp_CreateDate = date('YmdHis');

        $inputData = array(
            "vnp_Version" => "2.1.0",
            "vnp_TmnCode" => $vnp_TmnCode,
            "vnp_Amount" => $vnp_Amount,
            "vnp_Command" => "pay",
            "vnp_CreateDate" => $vnp_CreateDate,
            "vnp_CurrCode" => "VND",
            "vnp_IpAddr" => $vnp_IpAddr,
            "vnp_Locale" => $vnp_Locale,
            "vnp_OrderInfo" => $vnp_OrderInfo,
            "vnp_OrderType" => $vnp_OrderType,
            "vnp_ReturnUrl" => $vnp_Returnurl,
            "vnp_TxnRef" => $vnp_TxnRef,
        );

        // Sắp xếp mảng tham số (Bắt buộc)
        ksort($inputData);
        $query = "";
        $i = 0;
        $hashdata = "";
        foreach ($inputData as $key => $value) {
            if ($i == 1) {
                $hashdata .= '&' . urlencode($key) . "=" . urlencode($value);
            } else {
                $hashdata .= urlencode($key) . "=" . urlencode($value);
                $i = 1;
            }
            $query .= urlencode($key) . "=" . urlencode($value) . '&';
        }

        // Tạo URL và Mã Hash
        $vnp_Url = $vnp_Url . "?" . $query;
        if (isset($vnp_HashSecret)) {
            $vnpSecureHash = hash_hmac('sha512', $hashdata, $vnp_HashSecret);
            $vnp_Url .= 'vnp_SecureHash=' . $vnpSecureHash;
        }

        return $vnp_Url;
    }

    /**
     * Tính phí vận chuyển dựa trên Tỉnh/Thành
     */
    private function calculateShippingFee($tinhThanh)
    {
        $tinhThanhLower = Str::lower(trim($tinhThanh));
        $isHoChiMinh = Str::contains($tinhThanhLower, 'hồ chí minh');

        $tenPhiCanTim = $isHoChiMinh ? 'Nội tỉnh (TP.HCM)' : 'Ngoại tỉnh (các vùng lân cận)';

        $phivanchuyen = PhivanchuyenModel::where('ten', $tenPhiCanTim)
            ->where('trangthai', 'Hiển thị')
            ->first();

        return [
            'model' => $phivanchuyen,
            'phi' => $phivanchuyen->phi ?? 0,
        ];
    }
}
