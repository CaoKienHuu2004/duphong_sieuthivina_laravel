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
     * 1. ĐẶT HÀNG & TẠO THANH TOÁN VNPAY
     */
    public function placeOrder(Request $request)
    {
        $user = Auth::user();

        $request->validate([
            'id_phuongthuc' => 'required|exists:phuongthuc,id',
            'voucher_code' => 'nullable|string'
        ]);

        DB::beginTransaction();
        try {
            // Lấy dữ liệu giỏ hàng từ engine GiohangController đã viết
            $cartData = app(\App\Http\Controllers\client\api\GiohangController::class)->getCartDetails($request)->getData()->data;
            if (empty($cartData->items)) throw new \Exception('Giỏ hàng trống.');

            $diachi = DiachinguoidungModel::where('id_nguoidung', $user->id)->where('trangthai', 'Mặc định')->first();
            if (!$diachi) throw new \Exception('Vui lòng thiết lập địa chỉ mặc định.');

            $phuongthuc = PhuongthucModel::find($request->id_phuongthuc);
            $shipping = $this->calculateShippingFee($diachi->tinhthanh);
            $tongThanhToan = $cartData->summary->tonggiatri + $shipping['phi'];

            // Khởi tạo đơn hàng
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

            // Lưu chi tiết & Trừ tồn kho
            foreach ($cartData->items as $item) {
                ChitietdonhangModel::create([
                    'id_bienthe' => $item->id_bienthe,
                    'id_donhang' => $order->id,
                    'tensanpham' => $item->bienthe->sanpham->ten,
                    'tenbienthe' => $item->bienthe->loaibienthe->ten ?? '',
                    'soluong' => $item->soluong,
                    'dongia' => $item->thanhtien > 0 ? ($item->thanhtien / $item->soluong) : 0,
                ]);

                $bt = BientheModel::find($item->id_bienthe);
                $bt->soluong -= $item->soluong;
                if ($item->thanhtien == 0) $bt->luottang -= $item->soluong;
                $bt->luotban += $item->soluong;
                $bt->save();
            }

            // Xóa giỏ hàng database
            GiohangModel::where('id_nguoidung', $user->id)->delete();
            DB::commit();

            // XỬ LÝ THANH TOÁN VNPAY (Nếu chọn phương thức VNPAY)
            $paymentUrl = null;
            if ($phuongthuc->maphuongthuc == 'QRCODE') {
                $paymentUrl = $this->createVnpayPayment($order);
            }

            return response()->json([
                'status' => 200,
                'message' => 'Đặt hàng thành công!',
                'data' => [
                    'madon' => $order->madon,
                    'payment_url' => $paymentUrl // FE sẽ dùng link này để redirect khách
                ]
            ]);

        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['status' => 500, 'message' => $e->getMessage()], 500);
        }
    }

    /**
     * 2. TẠO URL THANH TOÁN VNPAY
     */
    private function createVnpayPayment($order)
    {
        $vnp_TmnCode = env('VNP_TMN_CODE');
        $vnp_HashSecret = env('VNP_HASH_SECRET');
        $vnp_Url = env('VNP_URL');
        $vnp_Returnurl = env('VNP_RETURN_URL');

        $vnp_TxnRef = $order->madon; 
        $vnp_OrderInfo = "Thanh toan don hang " . $order->madon;
        $vnp_OrderType = 'billpayment';
        $vnp_Amount = $order->thanhtien * 100; // VNPay tính theo đơn vị VND * 100
        $vnp_Locale = 'vn';
        $vnp_IpAddr = request()->ip();

        $inputData = array(
            "vnp_Version" => "2.1.0",
            "vnp_TmnCode" => $vnp_TmnCode,
            "vnp_Amount" => $vnp_Amount,
            "vnp_Command" => "pay",
            "vnp_CreateDate" => date('YmdHis'),
            "vnp_CurrCode" => "VND",
            "vnp_IpAddr" => $vnp_IpAddr,
            "vnp_Locale" => $vnp_Locale,
            "vnp_OrderInfo" => $vnp_OrderInfo,
            "vnp_OrderType" => $vnp_OrderType,
            "vnp_ReturnUrl" => $vnp_Returnurl,
            "vnp_TxnRef" => $vnp_TxnRef,
        );

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

        $vnp_Url = $vnp_Url . "?" . $query;
        if (isset($vnp_HashSecret)) {
            $vnpSecureHash = hash_hmac('sha512', $hashdata, $vnp_HashSecret);
            $vnp_Url .= 'vnp_SecureHash=' . $vnpSecureHash;
        }

        return $vnp_Url;
    }

    /**
     * 3. XỬ LÝ IPN (WEBHOOK VNPAY GỌI NGẦM)
     */
    public function vnpayIpn(Request $request)
    {
        $vnp_HashSecret = env('VNP_HASH_SECRET');
        $inputData = $request->all();
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

        $secureHash = hash_hmac('sha512', $hashData, $vnp_HashSecret);
        if ($secureHash == $vnp_SecureHash) {
            $order = DonhangModel::where('madon', $inputData['vnp_TxnRef'])->first();
            if ($order) {
                if ($inputData['vnp_ResponseCode'] == '00') {
                    $order->update(['trangthaithanhtoan' => 'Đã thanh toán']);
                }
                return response()->json(['RspCode' => '00', 'Message' => 'Confirm Success']);
            }
            return response()->json(['RspCode' => '01', 'Message' => 'Order not found']);
        }
        return response()->json(['RspCode' => '97', 'Message' => 'Invalid signature']);
    }

    private function calculateShippingFee($tinhThanh)
    {
        $tinhThanhLower = Str::lower(trim($tinhThanh));
        $tenPhi = Str::contains($tinhThanhLower, 'hồ chí minh') ? 'Nội tỉnh (TP.HCM)' : 'Ngoại tỉnh (các vùng lân cận)';
        $model = PhivanchuyenModel::where('ten', $tenPhi)->where('trangthai', 'Hiển thị')->first();
        return ['model' => $model, 'phi' => $model->phi ?? 0];
    }
}