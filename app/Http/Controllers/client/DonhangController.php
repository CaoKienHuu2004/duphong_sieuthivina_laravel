<?php

namespace App\Http\Controllers\client;

use App\Http\Controllers\Controller;
use App\Mail\HuydonhangMail;
use App\Models\DonhangModel;
use App\Models\ThongbaoModel;
use App\Models\BientheModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class DonhangController extends Controller
{
    public function donhangcuatoi()
    {
        return view('client.nguoidung.donhang');
    }

    public function chitietdonhang($madon)
    {
        $donhang = DonhangModel::where('madon', $madon)->firstOrFail();

        return view('client.nguoidung.chitietdonhang', compact('donhang'));
    }

    public function huydonhang(Request $request)
    {
        $id_donhang = $request->input('id_donhang');

        $donhang = DonhangModel::find($id_donhang);

        if ($donhang && ($donhang->trangthai == 'Chờ xác nhận' || $donhang->trangthai == 'Chờ thanh toán')) {
            $donhang->trangthai = 'Đã hủy đơn';
            $donhang->trangthaithanhtoan = 'Hủy thanh toán';
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

            ThongbaoModel::khoitaothongbao(
                $donhang->id_nguoidung,
                "Đơn hàng của bạn đã bị hủy !",
                "Mã đơn {$donhang->madon} của bạn đã bị hủy, vui lòng xem chi tiết đơn hàng.",
                route('chi-tiet-don-hang', $donhang->madon),
                'Đơn hàng'
            );

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

            return redirect()->back()->with('success', 'Đơn hàng đã được hủy thành công.');
        }

        

        return redirect()->back()->with('error', 'Không thể hủy đơn hàng này.');
    }

    public function tracuudonhang()
    {
        return view('client.thanhtoan.tracuudonhang');
    }

    public function tracuu(Request $request)
    {
        $madon = $request->input('madon');

        $donhang = DonhangModel::where('madon', $madon)->first();

        if ($donhang) {
            return view('client.thanhtoan.tracuudonhang', compact('donhang'));
        } else {
            return redirect()->back()->with('error', 'Mã đơn hàng không tồn tại.');
        }
    }
    
}
