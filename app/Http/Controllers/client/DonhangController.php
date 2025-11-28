<?php

namespace App\Http\Controllers\client;

use App\Http\Controllers\Controller;
use App\Models\DonhangModel;
use App\Models\ThongbaoModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

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
            $donhang->save();

            ThongbaoModel::khoitaothongbao(
                $donhang->id_nguoidung,
                "Đơn hàng của bạn đã bị hủy !",
                "Mã đơn {$donhang->madon} của bạn đã bị hủy, vui lòng xem chi tiết đơn hàng.",
                route('chi-tiet-don-hang', $donhang->madon),
                'Đơn hàng'
            );

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
