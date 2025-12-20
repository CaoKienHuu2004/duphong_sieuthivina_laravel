<?php

namespace App\Http\Controllers\client\api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use Carbon\Carbon;
use App\Models\DonhangModel;
use App\Models\ChitietdonhangModel;
use App\Models\DiachinguoidungModel;
use App\Models\GiohangModel;
use App\Models\PhuongthucModel;
use App\Models\PhivanchuyenModel;
use App\Models\ThongbaoModel;
use App\Models\BientheModel;

class ThanhtoanController extends Controller
{
    /**
     * 1. Xử lý Đặt hàng & Thanh toán Momo
     */
    public function placeOrder(Request $request)
    {
        // Vì đã bọc middleware 'auth:sanctum' nên chắc chắn đã login
        $user = Auth::user();

        $request->validate([
            'id_phuongthuc' => 'required|exists:phuongthuc,id',
            'voucher_code' => 'nullable|string'
        ]);

        DB::beginTransaction();
        try {
            // Lấy data giỏ hàng từ Engine đã viết ở GiohangController
            $cartData = app(\App\Http\Controllers\client\api\ApiGiohangController::class)->getCartDetails($request)->getData()->data;
            
            if (empty($cartData->items)) throw new \Exception('Giỏ hàng của bạn đang trống.');

            // Lấy địa chỉ mặc định
            $diachi = DiachinguoidungModel::where('id_nguoidung', $user->id)->where('trangthai', 'Mặc định')->first();
            if (!$diachi) throw new \Exception('Vui lòng thiết lập địa chỉ mặc định trước khi đặt hàng.');

            $phuongthuc = PhuongthucModel::find($request->id_phuongthuc);
            $shipping = $this->calculateShippingFee($diachi->tinhthanh);
            $tongThanhToan = $cartData->summary->tonggiatri + $shipping['phi'];

            // Tạo đơn hàng
            $order = new DonhangModel();
            $order->id_nguoidung = $user->id;
            $order->id_phuongthuc = $phuongthuc->id;
            $order->id_diachinguoidung = $diachi->id;
            $order->id_phivanchuyen = $shipping['model']->id ?? null;
            $order->id_magiamgia = $cartData->summary->voucher_info->id ?? null;
            $order->madon = 'TEMP';
            $order->nguoinhan = $diachi->hoten;
            $order->diachinhan = $diachi->diachi . ', ' . $diachi->phuongxa . ', ' . $diachi->quanhuyen . ', ' . $diachi->tinhthanh;
            $order->khuvucgiao = $diachi->tinhthanh;
            $order->hinhthucvanchuyen = $shipping['model']->ten;
            $order->phigiaohang = $shipping['phi'];
            $order->hinhthucthanhtoan = $phuongthuc->ten;
            $order->sodienthoai = $diachi->sodienthoai;
            $order->mavoucher = $cartData->summary->voucher_info->magiamgia ?? null;
            $order->giagiam = $cartData->summary->giamgia_voucher;
            $order->tamtinh = $cartData->summary->tamtinh;
            $order->thanhtien = $tongThanhToan;
            $order->trangthai = 'Chờ xác nhận';
            $order->trangthaithanhtoan = ($phuongthuc->maphuongthuc == 'COD') ? 'Thanh toán khi nhận hàng' : 'Chờ thanh toán';
            $order->save();

            $order->madon = 'STV' . Carbon::now()->format('ymd') . $order->id;
            $order->save();

            // Lưu chi tiết & Trừ kho
            foreach ($cartData->items as $item) {
                $bienthe = BientheModel::find($item->id_bienthe);
                if ($bienthe->soluong < $item->soluong) throw new \Exception("Sản phẩm {$bienthe->sanpham->ten} đã hết hàng.");

                ChitietdonhangModel::create([
                    'id_bienthe' => $item->id_bienthe,
                    'id_donhang' => $order->id,
                    'tensanpham' => $item->bienthe->sanpham->ten,
                    'tenbienthe' => $item->bienthe->loaibienthe->ten ?? '',
                    'soluong' => $item->soluong,
                    'dongia' => $item->thanhtien > 0 ? ($item->thanhtien / $item->soluong) : 0,
                ]);

                $bienthe->soluong -= $item->soluong;
                if ($item->thanhtien == 0) $bienthe->luottang -= $item->soluong; // Trừ lượt tặng nếu là quà
                $bienthe->luotban += $item->soluong;
                $bienthe->save();
            }

            // Xóa giỏ hàng sau khi đặt thành công
            GiohangModel::where('id_nguoidung', $user->id)->delete();
            
            DB::commit();

            // Gửi thông báo
            ThongbaoModel::khoitaothongbao($user->id, "Đặt hàng thành công", "Đơn hàng {$order->madon} đang chờ xác nhận.", "#", "Đơn hàng");

            // XỬ LÝ THANH TOÁN MOMO
            if ($phuongthuc->maphuongthuc == 'MOMO') {
                return $this->processMomoPayment($order);
            }

            return response()->json([
                'status' => 200,
                'message' => 'Đặt hàng thành công (COD)!',
                'data' => ['madon' => $order->madon]
            ]);

        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['status' => 500, 'message' => $e->getMessage()], 500);
        }
    }

    /**
     * Tích hợp Momo (Cấu hình đầy đủ tham số)
     */
    private function processMomoPayment($order)
    {
        $endpoint = "https://test-payment.momo.vn/v2/gateway/api/create"; // Link test

        $partnerCode = env('MOMO_PARTNER_CODE', 'MOMOBKUN20180529');
        $accessKey = env('MOMO_ACCESS_KEY', 'klm05nuEHM7HGDLS');
        $secretKey = env('MOMO_SECRET_KEY', 'at67qH6mk8w5Y1n71y98uQ94L7uU8LbE');
        
        $orderInfo = "Thanh toán đơn hàng " . $order->madon . " tại Siêu Thị Vina";
        $redirectUrl = url('/api/v1/checkout/momo-return'); // Link FE nhận kết quả
        $ipnUrl = url('/api/v1/checkout/momo-ipn'); // Link BE nhận kết quả ngầm
        $amount = (string)$order->thanhtien;
        $orderId = $order->madon . "_" . time(); // Đảm bảo ID duy nhất cho mỗi lần bấm thanh toán
        $requestId = (string)time();
        $requestType = "captureWallet";
        $extraData = "";

        // Tạo chữ ký (Signature) theo chuẩn Momo
        $rawHash = "accessKey=$accessKey&amount=$amount&extraData=$extraData&ipnUrl=$ipnUrl&orderId=$orderId&orderInfo=$orderInfo&partnerCode=$partnerCode&redirectUrl=$redirectUrl&requestId=$requestId&requestType=$requestType";
        $signature = hash_hmac("sha256", $rawHash, $secretKey);

        $data = [
            'partnerCode' => $partnerCode,
            'requestId' => $requestId,
            'amount' => $amount,
            'orderId' => $orderId,
            'orderInfo' => $orderInfo,
            'redirectUrl' => $redirectUrl,
            'ipnUrl' => $ipnUrl,
            'extraData' => $extraData,
            'requestType' => $requestType,
            'signature' => $signature,
            'lang' => 'vi'
        ];

        // Gửi request lên Momo
        $ch = curl_init($endpoint);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, ['Content-Type: application/json']);
        $result = curl_exec($ch);
        curl_close($ch);

        $res = json_decode($result, true);

        if (isset($res['payUrl'])) {
            return response()->json([
                'status' => 200,
                'message' => 'Chuyển hướng đến Momo',
                'payUrl' => $res['payUrl'],
                'madon' => $order->madon
            ]);
        }

        return response()->json(['status' => 500, 'message' => 'Lỗi kết nối Momo: ' . ($res['message'] ?? 'Unknown')], 500);
    }

    private function calculateShippingFee($tinhThanh)
    {
        $tinhThanhLower = Str::lower(trim($tinhThanh));
        $tenPhi = Str::contains($tinhThanhLower, 'hồ chí minh') ? 'Nội tỉnh (TP.HCM)' : 'Ngoại tỉnh (các vùng lân cận)';
        $model = PhivanchuyenModel::where('ten', $tenPhi)->where('trangthai', 'Hiển thị')->first();
        return ['model' => $model, 'phi' => $model->phi ?? 0];
    }
}