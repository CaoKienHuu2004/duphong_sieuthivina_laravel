<?php

namespace App\Http\Controllers\client;

use App\Http\Controllers\Controller;
use App\Mail\Xacnhandonhang;
use Illuminate\Support\Facades\Mail;
use App\Models\MaGiamGia;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Log;
use Carbon\Carbon;
use App\Models\DonhangModel;
use App\Models\ChitietdonhangModel;
use App\Models\DiachinguoidungModel;
use App\Models\GiohangModel;
use App\Models\PhuongthucModel;
use App\Models\PhivanchuyenModel;
use App\Models\ThongbaoModel;
use App\Models\MagiamgiaModel;
use App\Models\BientheModel;
use App\Livewire\GiohangComponent;

class ThanhtoanController extends Controller
{
    private function calculateShippingFee($tinhThanh)
    {
        // 1. Chuẩn hóa tên tỉnh thành để kiểm tra (chỉ cần kiểm tra "hồ chí minh")
        $tinhThanhLower = Str::lower(trim($tinhThanh));
        $isHoChiMinh = Str::contains($tinhThanhLower, 'hồ chí minh');
        
        // 2. Xác định tên phí cần tìm trong Model dựa trên kết quả kiểm tra
        if ($isHoChiMinh) {
            // Tên phí dựa trên bảng của bạn (id=1)
            $tenPhiCanTim = 'Nội tỉnh (TP.HCM)';
        } else {
            // Tên phí dựa trên bảng của bạn (id=2)
            $tenPhiCanTim = 'Ngoại tỉnh (các vùng lân cận)';
        }

        // 3. Lấy Phí vận chuyển từ Model bằng cú pháp where() rõ ràng
        // Lưu ý: Đã sửa trạng thái từ 'Hoạt động' sang 'Hiển thị'
        $phivanchuyen = PhivanchuyenModel::where('ten', $tenPhiCanTim)
                                        ->where('trangthai', 'Hiển thị') // <== Đã sửa trạng thái
                                        ->first();
        
        // 4. Trả về kết quả
        return [
            'model' => $phivanchuyen, // Model phí vận chuyển
            'phi' => $phivanchuyen->phi ?? 0, // Giá trị phí vận chuyển, mặc định là 0
        ];
    }
    
    // ---

    /**
     * Hiển thị trang Thanh toán.
     */
    public function index()
    {
        if (!Auth::check()) {
            return redirect()->route('login')->with('error', 'Vui lòng đăng nhập để tiến hành thanh toán.');
        }

        // 1. Tải dữ liệu giỏ hàng (từ Livewire Component)
        $giohangComponent = new GiohangComponent();
        $giohangComponent->mount();
        if (empty($giohangComponent->giohang)) {
            return redirect()->route('gio-hang')->with('error', 'Giỏ hàng của bạn đang trống.');
        }

        // 2. Lấy Địa chỉ MẶC ĐỊNH (Không dùng Scope MacDinh)
        $diachiMacDinh = DiachinguoidungModel::where('id_nguoidung', Auth::id())
                                        ->where('trangthai', 'Mặc định')
                                        ->first();

        if (!$diachiMacDinh) {
            return redirect()->route('so-dia-chi')->with('error', 'Vui lòng chọn địa chỉ mặc định nhận hàng.');
        }

        // 3. Tính toán Phí Vận Chuyển
        $shipping = $this->calculateShippingFee($diachiMacDinh->tinhthanh);
        $phiVanChuyen = $shipping['phi'];
        $phivanchuyenModel = $shipping['model'];

        // 4. Tính Tổng Thanh Toán Cuối Cùng
        $tongThanhTien = $giohangComponent->tonggiatri + $phiVanChuyen;
        if ($tongThanhTien < 0) $tongThanhTien = 0;

        // 5. Chuẩn bị dữ liệu trả về View
        $phuongthucs = PhuongthucModel::where('trangthai', 'Hoạt động') // <== Thay thế cho ->HoatDong()
                                      ->get();
        
        $cartData = [
            'giohang' => $giohangComponent->giohang,
            'tamtinh' => $giohangComponent->tamtinh,
            'giamgiaVoucher' => $giohangComponent->giamgiaVoucher,
            'tonggiatri_sau_giamgia' => $giohangComponent->tonggiatri, 
            'tong_thanh_toan' => $tongThanhTien, 
            'appliedVoucher' => $giohangComponent->appliedVoucher,
            'tongsoquatang' => $giohangComponent->tongsoquatang,
            'tietkiem' => $giohangComponent->tietkiem,
        ];

        $diachis = DiachinguoidungModel::where('id_nguoidung', Auth::id())->orderBy('trangthai', 'asc')->get();

        return view('client.thanhtoan.thanhtoan', compact(
            'cartData',
            'diachiMacDinh', 
            'phuongthucs', 
            'phivanchuyenModel',
            'phiVanChuyen',
            'diachis',
        ));
    }

    public function placeOrder(Request $request)
    {
        if (!Auth::check()) {
            return redirect()->route('login')->with('error', 'Vui lòng đăng nhập để đặt hàng.');
        }

        $request->validate([
            'id_phuongthuc' => 'required|exists:phuongthuc,id',
        ]);
        
        DB::beginTransaction();

        try {
            // TÁI TẠO LOGIC TÍNH TOÁN
            $giohangComponent = new GiohangComponent();
            $giohangComponent->mount();
            
            $cartItems = $giohangComponent->giohang;
            $tamtinh = $giohangComponent->tamtinh;
            $giamgiaVoucher = $giohangComponent->giamgiaVoucher;
            $appliedVoucher = $giohangComponent->appliedVoucher;

            if (empty($cartItems)) {
                DB::rollBack();
                return redirect()->route('gio-hang')->with('error', 'Giỏ hàng trống, không thể đặt hàng.');
            }

            // Lấy Địa chỉ MẶC ĐỊNH (Không dùng Scope MacDinh)
            $diachi = DiachinguoidungModel::where('id_nguoidung', Auth::id())
                                        ->where('trangthai', 'Mặc định')
                                        ->first();
                        
            if (!$diachi) {
                 DB::rollBack();
                 return redirect()->route('thay-doi-dia-chi')->with('error', 'Vui lòng chọn địa chỉ nhận hàng trước khi đặt.');
            }
            
            // Lấy Phương thức thanh toán
            $phuongthuc = PhuongthucModel::find($request->id_phuongthuc);

            // TÍNH TOÁN PHÍ VẬN CHUYỂN DỰA TRÊN ĐỊA CHỈ MẶC ĐỊNH
            $shipping = $this->calculateShippingFee($diachi->tinhthanh);
            $phiVanChuyen = $shipping['phi'];
            $phivanchuyenModel = $shipping['model'];

            // Tính toán Thành tiền cuối cùng
            $tongThanhTien = $tamtinh - $giamgiaVoucher + $phiVanChuyen;
            if ($tongThanhTien < 0) $tongThanhTien = 0; 

            $currentDateTime = Carbon::now()->format('ymd');
            // 2. TẠO ĐƠN HÀNG (DonhangModel)
            // ********** BƯỚC 1: LƯU TẠM THỜI ĐỂ LẤY ID ĐƠN HÀNG **********
            $order = new DonhangModel();
            $order->id_nguoidung = Auth::id();
            $order->id_phuongthuc = $phuongthuc->id;
            $order->id_diachinguoidung = $diachi->id; 
            $order->id_phivanchuyen = $phivanchuyenModel->id ?? null;

            // Sửa lỗi Foreign Key: Lấy ID mã giảm giá, nếu không có thì là NULL
            $voucherId = $appliedVoucher['id'] ?? null;
            if($voucherId == null){
                $order->id_magiamgia = null;
            }else{
                $magiamgiaModel = MagiamgiaModel::where('id',$voucherId)->firstOrFail();
                $order->id_magiamgia = $voucherId;
            }
            

            // Mã đơn hàng ban đầu là một giá trị tạm thời (TEMP)
            $order->madon = 'TEMP';
            $order->nguoinhan = $diachi->hoten;
            $order->diachinhan = $diachi->diachi;
            $order->khuvucgiao = $diachi->tinhthanh;
            $order->hinhthucvanchuyen = $phivanchuyenModel->ten;
            $order->phigiaohang = $phiVanChuyen;
            $order->hinhthucthanhtoan = $phuongthuc->ten;
            $order->sodienthoai = $diachi->sodienthoai;
            $order->mavoucher = $magiamgiaModel->magiamgia ?? null;
            $order->giagiam = $giamgiaVoucher ?? null;
            // $order->tongsoluong = collect($cartItems)->sum('soluong');
            $order->tamtinh = $tamtinh;
            $order->thanhtien = $tongThanhTien;
            $order->trangthai = 'Chờ xác nhận'; 
            if($phuongthuc->maphuongthuc == 'COD') {
                $order->trangthaithanhtoan = 'Thanh toán khi nhận hàng';
            } else {
                $order->trangthaithanhtoan = 'Chờ thanh toán';
            }
            $order->save();

            $currentDateTime = Carbon::now()->format('ymd');
            $order->madon = 'STV' . $currentDateTime . $order->id;
            $order->save();

            ThongbaoModel::khoitaothongbao(
                $order->id_nguoidung,
                "Bạn đã đặt hàng thành công !",
                "Mã đơn {$order->madon} của bạn, vui lòng kiểm tra đơn hàng của bạn.",
                route('chi-tiet-don-hang', $order->madon), // Giả định có route xem chi tiết đơn hàng
                'Đơn hàng'
            );

            foreach ($cartItems as $item) {
                $bientheId = $item['id_bienthe'];
                $bientheModel = BientheModel::where('id',$bientheId)->firstOrFail();
                $soluong = $item['soluong'];
                $dongia = $item['thanhtien']; 

                ChitietdonhangModel::create([
                    'id_bienthe' => $bientheId,
                    'id_donhang' => $order->id,
                    'tensanpham' => $bientheModel->sanpham->ten,
                    'tenbienthe' => $bientheModel->loaibienthe->ten,
                    'soluong' => $soluong,
                    'dongia' => $dongia,
                ]);

                // CHỈ TRỪ TỒN KHO CHO SẢN PHẨM MUA (thanhtien > 0)
                // TRƯỜNG HỢP QUÀ TẶNG (thanhtien = 0) VẪN CẦN TRỪ TỒN KHO NHƯ BÌNH THƯỜNG VÀ CÒN TRỪ SỐ LƯỢNG TẶNG (LUOTTANG)
                if ($item['thanhtien'] > 0) { 
                    $bienthe = BientheModel::find($bientheId);
                    if ($bienthe) {
                        $bienthe->soluong -= $soluong;
                        if ($bienthe->soluong < 0) {
                             DB::rollBack();
                             return redirect()->back()->with('error', 'Lỗi: Sản phẩm **' . ($bienthe->sanpham->ten ?? '') . '** không đủ số lượng tồn kho.');
                        }
                        $bienthe->luotban += $soluong; 
                        $bienthe->save();
                    }
                }elseif ($item['thanhtien'] == 0) { 
                    $bienthe = BientheModel::find($bientheId);
                    if ($bienthe) {
                        $bienthe->soluong -= $soluong;
                        $bienthe->luottang -= $soluong;
                        if ($bienthe->soluong < 0) {
                             DB::rollBack();
                             return redirect()->back()->with('error', 'Lỗi: Sản phẩm **' . ($bienthe->sanpham->ten ?? '') . '** không đủ số lượng tồn kho.');
                        }
                        $bienthe->luotban += $soluong; 
                        $bienthe->save();
                    }
                }
            }
            
            // 4. DỌN DẸP
            GiohangModel::where('id_nguoidung', Auth::id())->delete();
            Session::forget('cart');
            Session::forget('applied_voucher');

            // Mail::to(Auth::user()->email)->send(new Xacnhandonhang($order, Auth::user()));
            
            // 5. Kết thúc Transaction
            DB::commit();

            return redirect()->route('dat-hang-thanh-cong', ['madon' => $order->madon])
                             ->with('success', 'Đơn hàng **' . $order->madon . '** của bạn đã được đặt thành công!');

        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Lỗi đặt hàng: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Đã xảy ra lỗi trong quá trình đặt hàng. (Chi tiết lỗi: ' . $e->getMessage() . ').');
        }
    }
    public function orderSuccess(Request $request)
    {
        if (!Auth::check()) {
            return redirect()->route('login')->with('error', 'Vui lòng đăng nhập để đặt hàng.');
        }

        $madon = $request->query('madon');
        $donhang = DonhangModel::with([
            'chitietdonhang.bienthe.sanpham.hinhanhsanpham',
            'phuongthuc', 
            'diachinguoidung', 
            'phivanchuyen', 
            'magiamgia' 
        ])
        ->where('madon', $madon) 
        ->where('id_nguoidung', Auth::id()) 
        ->first(); 

        if (!$donhang) {
            return redirect()->back()->with('error', 'Đơn hàng không tồn tại.');
        }

        // --- TẠO MÃ QR VIETQR TỰ ĐỘNG ---
        $qrCodeUrl = null;

        if ($donhang->trangthaithanhtoan !== 'Đã thanh toán') {
            
            $bankId = 'TPB'; 
            $accountNo = '00117137001'; 
            $accountName = 'TRAN BA HO'; 
            $template = 'compact2'; 

            $amount = $donhang->thanhtien;
            
            // CẬP NHẬT: Nội dung có dấu cách và thêm tiền tố
            $rawContent = "Thanh toan don hang " . $donhang->madon;
            
            // MÃ HÓA URL (URL Encode) để xử lý khoảng trắng
            $description = urlencode($rawContent);
            
            // Mã hóa cả tên tài khoản cho an toàn (phòng trường hợp có ký tự lạ)
            $encodedAccountName = urlencode($accountName);

            $qrCodeUrl = "https://img.vietqr.io/image/{$bankId}-{$accountNo}-{$template}.png?amount={$amount}&addInfo={$description}&accountName={$encodedAccountName}";
        }

        return view('client.thanhtoan.dathangthanhcong', compact('donhang', 'qrCodeUrl'));
    }
}