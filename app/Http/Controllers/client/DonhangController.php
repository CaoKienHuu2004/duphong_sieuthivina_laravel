<?php

namespace App\Http\Controllers\client;

use App\Http\Controllers\Controller;
use App\Models\DonhangModel;
use Illuminate\Http\Request;

class DonhangController extends Controller
{
    public function donhangcuatoi()
    {
        return view('client.nguoidung.donhang');
    }

    public function chitietdonhang($madon)
    {
        $donhang = DonhangModel::where('madon', $madon)->first();

        return view('client.nguoidung.chitietdonhang', compact('donhang'));
    }

    public function huydonhang(Request $request)
    {
        $id_donhang = $request->input('id_donhang');

        $donhang = DonhangModel::find($id_donhang);

        if ($donhang && ($donhang->trangthai == 'Chờ xác nhận' || $donhang->trangthai == 'Chờ thanh toán')) {
            $donhang->trangthai = 'Đã hủy đơn';
            $donhang->save();

            return redirect()->back()->with('success', 'Đơn hàng đã được hủy thành công.');
        }

        return redirect()->back()->with('error', 'Không thể hủy đơn hàng này.');
    }
    
}
