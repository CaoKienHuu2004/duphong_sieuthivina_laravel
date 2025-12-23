<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Mail\CapnhattrangthaiMail;
use Illuminate\Support\Str;
use App\Models\DonhangModel as Donhang;
use App\Models\ChitietdonhangModel as ChitietDonhang;
use App\Models\NguoidungModel as Nguoidung;
use App\Models\SanphamModel as Sanpham;
use Illuminate\Http\Request;
use App\Models\BientheModel as Bienthe;
use App\Models\ThongbaoModel;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Route;

class DonhangController extends Controller
{
    // Danh sách đơn hàng
    public function index()
    {
        $donhangs = Donhang::orderByDesc('created_at')->get();

        return view('admin.donhang.index', compact('donhangs'));
    }

    // Chi tiết đơn hàng
    public function show($madon)
    {
        $donhang = Donhang::where('madon', $madon)->firstOrFail();

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

        return view('admin.donhang.chitiet', compact('donhang', 'qrCodeUrl'));
    }

    public function actionCapNhatTrangThai(Request $request, $id)
    {
        // --- BƯỚC 1: Tìm đơn hàng ---
        $donhang = Donhang::findOrFail($id);

        // Lấy trạng thái mới từ request
        $trangThaiMoi = $request->input('trang_thai_moi');
        $trangThaiHienTai = $donhang->trangthai;

        // --- BƯỚC 2: Quy tắc chuyển đổi ---
        $quyTacChuyenDoi = [
            'Chờ xác nhận'   => ['Đang đóng gói', 'Đã hủy đơn'],
            'Đang đóng gói'  => ['Đang giao hàng', 'Đã hủy đơn'],
            'Đang giao hàng' => ['Đã giao hàng', 'Đã hủy đơn'],
            // Thêm các trạng thái khác nếu cần (ví dụ từ Đã giao hàng -> Hoàn thành)
        ];

        // --- BƯỚC 3: Validate ---
        if (!$trangThaiMoi) {
            return back()->with('error', 'Dữ liệu trạng thái mới không tồn tại.');
        }

        if (!array_key_exists($trangThaiHienTai, $quyTacChuyenDoi)) {
            // Có thể lỏng tay đoạn này nếu muốn admin quyền lực hơn
            return back()->with('error', "Trạng thái '$trangThaiHienTai' không hỗ trợ cập nhật tiếp theo quy trình.");
        }

        $cacTrangThaiDuocPhep = $quyTacChuyenDoi[$trangThaiHienTai];
        if (!in_array($trangThaiMoi, $cacTrangThaiDuocPhep)) {
            return back()->with('error', "Không thể chuyển từ '$trangThaiHienTai' sang '$trangThaiMoi'.");
        }

        // --- BƯỚC 4: Cập nhật & Lưu ---
        $donhang->trangthai = $trangThaiMoi;

        // Xử lý logic phụ (Hoàn kho nếu hủy...)
        if ($trangThaiMoi == 'Đã hủy đơn') {
            // Logic hoàn kho...
        }

        $donhang->save();

        // --- BƯỚC 5: Gửi thông báo cho người dùng (Đã thêm mới) ---
        // Tùy chỉnh nội dung thông báo dựa trên trạng thái mới
        $tieude = "";
        $noidung = "";

        switch ($trangThaiMoi) {
            case 'Đang đóng gói':
                $tieude = "Đơn hàng đã được xác nhận";
                $noidung = "Đơn hàng #{$donhang->madon} của bạn đã được xác nhận và đang trong quá trình đóng gói.";
                break;
            case 'Đang giao hàng':
                $tieude = "Đơn hàng đang được giao";
                $noidung = "Đơn hàng #{$donhang->madon} đã được bàn giao cho đơn vị vận chuyển.";
                break;
            case 'Đã giao hàng':
                $tieude = "Giao hàng thành công";
                $noidung = "Đơn hàng #{$donhang->madon} đã được giao thành công. Cảm ơn bạn đã mua sắm!";
                break;
            case 'Đã hủy đơn':
                $tieude = "Đơn hàng đã bị hủy";
                $noidung = "Đơn hàng #{$donhang->madon} của bạn đã bị hủy. Vui lòng liên hệ nếu có nhầm lẫn.";
                break;
            default:
                $tieude = "Cập nhật đơn hàng";
                $noidung = "Đơn hàng #{$donhang->madon} đã chuyển sang trạng thái: $trangThaiMoi.";
                break;
        }

        // Thực hiện gửi thông báo
        if ($donhang->id_nguoidung && !empty($tieude) && !empty($noidung)) {
            // Kiểm tra xem route chi tiết có tồn tại không để tránh lỗi route
            $link = Route::has('quan-tri-vien.chi-tiet-don-hang')
                ? route('quan-tri-vien.chi-tiet-don-hang', $donhang->madon)
                : '#'; // Hoặc đường dẫn mặc định
            ThongbaoModel::khoitaothongbao(
                $donhang->id_nguoidung,
                $tieude,
                $noidung,
                $link,
                'Đơn hàng'
            );

            // 6.2 [MỚI] Gửi Email
            // Gửi Mail
            try {
                $emailNhan = $donhang->nguoidung ? $donhang->nguoidung->email : null;

                if ($emailNhan) {
                    // Mail::to tự động nhận class Mailable
                    Mail::to($emailNhan)->send(
                        new CapNhatTrangThaiMail($donhang, $tieude, $noidung)
                    );
                }
            } catch (\Exception $e) {
                Log::error("Lỗi gửi mail: " . $e->getMessage());
            }
        }





        // --- BƯỚC 6: Redirect ---
        return redirect()->back()
            ->with('success', "Đã cập nhật trạng thái thành: $trangThaiMoi");
    }
}
