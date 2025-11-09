<?php

namespace App\Http\Controllers\client;

use App\Http\Controllers\Controller;
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
            return redirect()->route('cart')->with('error', 'Giỏ hàng của bạn đang trống.');
        }

        // 2. Lấy Địa chỉ MẶC ĐỊNH (Không dùng Scope MacDinh)
        $diachiMacDinh = DiachinguoidungModel::where('id_nguoidung', Auth::id())
                                        ->where('trangthai', 'Mặc định')
                                        ->first();

        if (!$diachiMacDinh) {
            return redirect()->route('thay-doi-dia-chi')->with('info', 'Vui lòng chọn địa chỉ nhận hàng.');
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

        return view('client.thanhtoan.thanhtoan', compact(
            'cartData',
            'diachiMacDinh', 
            'phuongthucs', 
            'phivanchuyenModel',
            'phiVanChuyen'
        ));
    }

    public function placeOrder(Request $request)
    {
        if (!Auth::check()) {
            return response()->json(['success' => false, 'message' => 'Vui lòng đăng nhập để đặt hàng.'], 401);
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
                return redirect()->route('cart')->with('error', 'Giỏ hàng trống, không thể đặt hàng.');
            }

            // Lấy Địa chỉ MẶC ĐỊNH (Không dùng Scope MacDinh)
            $diachi = DiachinguoidungModel::where('id_nguoidung', Auth::id())
                                        ->where('trangthai', 'Mặc định')
                                        ->first();
                        
            if (!$diachi) {
                 DB::rollBack();
                 return redirect()->route('checkout.address.select')->with('error', 'Vui lòng chọn địa chỉ nhận hàng trước khi đặt.');
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

            // 2. TẠO ĐƠN HÀNG (DonhangModel)
            $order = new DonhangModel();
            $order->id_nguoidung = Auth::id();
            $order->id_phuongthuc = $phuongthuc->id;
            $order->id_diachinguoidung = $diachi->id; 
            $order->id_phivanchuyen = $phivanchuyenModel->id ?? null;
            $order->id_magiamgia = $appliedVoucher['id'] ?? null;
            $order->madon = 'STV' . time() . Auth::id(); 
            $order->tongsoluong = collect($cartItems)->sum('soluong');
            $order->tamtinh = $tamtinh;
            $order->thanhtien = $tongThanhTien;
            $order->trangthai = 'Đang xác nhận';
            $order->save();

            // 3. LƯU CHI TIẾT ĐƠN HÀNG (ChitietdonhangModel) & CẬP NHẬT TỒN KHO
            foreach ($cartItems as $item) {
                $bientheId = $item['id_bienthe'];
                $soluong = $item['soluong'];
                $dongia = $item['thanhtien'] > 0 ? ($item['thanhtien'] / $soluong) : 0; 

                ChitietdonhangModel::create([
                    'id_bienthe' => $bientheId,
                    'id_donhang' => $order->id,
                    'soluong' => $soluong,
                    'dongia' => $dongia,
                ]);

                // CHỈ TRỪ TỒN KHO CHO SẢN PHẨM MUA (thanhtien > 0)
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
                }

                if ($item['thanhtien'] == 0) { 
                    $bienthe = BientheModel::find($bientheId);
                    if ($bienthe) {
                        $bienthe->soluong -= $soluong;
                        if ($bienthe->soluong < 0) {
                             DB::rollBack();
                             return redirect()->back()->with('error', 'Lỗi: Sản phẩm **' . ($bienthe->sanpham->ten ?? '') . '** không đủ số lượng tồn kho.');
                        }
                        $bienthe->luottang += $soluong; 
                        $bienthe->save();
                    }
                }
            }
            
            // 4. DỌN DẸP
            GiohangModel::where('id_nguoidung', Auth::id())->delete();
            Session::forget('cart');
            Session::forget('applied_voucher');
            
            // 5. Kết thúc Transaction
            DB::commit();
            

            return redirect()->route('tai-khoan', ['madon' => $order->madon])
                             ->with('success', 'Đơn hàng **' . $order->madon . '** của bạn đã được đặt thành công!');

        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Lỗi đặt hàng: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Đã xảy ra lỗi trong quá trình đặt hàng. Vui lòng thử lại.');
        }
    }
}