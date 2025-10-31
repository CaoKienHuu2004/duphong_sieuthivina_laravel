<?php

namespace App\Http\Controllers\client;

use App\Http\Controllers\Controller;
use App\Models\BientheModel;
use App\Models\GiohangModel;
use App\Models\NguoidungModel;
use App\Models\SanphamModel;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class GiohangController extends Controller
{
    public function index()
    {
        // 1. Thực thi truy vấn với Eager Loading
        $giohangItems = GiohangModel::with([
            'bienthe.sanpham',
            'bienthe.loaibienthe',
            'bienthe.sanpham.hinhanhsanpham',
            'bienthe.sanpham.thuonghieu'
        ])
        ->where('id_nguoidung', Auth::id())
        ->where('trangthai', 'Hiển thị')
        ->get();
        
        // 2. 🔄 THÊM THUỘC TÍNH GIÁ ĐƠN VỊ VÀO MỖI ITEM (Sử dụng Collection map)
        $giohangItems = $giohangItems->map(function ($item) {
            $bienthe = $item->bienthe;
            
            // --- Tính toán giá đã giảm ---
            $giaGocDonVi = $bienthe->giagoc;
            $giamGiaPhanTram = $bienthe->sanpham->giamgia ?? 0;
            
            $giaDaGiamDonVi = $giaGocDonVi; // Giá mặc định là giá gốc
            
            if ($giamGiaPhanTram > 0) {
                $tyLeGiam = $giamGiaPhanTram / 100;
                $giaDaGiamTam = $giaGocDonVi * (1 - $tyLeGiam);
                $giaDaGiamDonVi = round($giaDaGiamTam);
            }
            
            // Thêm các thuộc tính mới vào đối tượng $item (chỉ tồn tại trong Controller/View)
            $item->gia_goc_don_vi = $giaGocDonVi;
            $item->gia_da_giam_don_vi = $giaDaGiamDonVi;

            return $item;
        });

        // 3. Tính tổng thanh toán cuối cùng
        $tongthanhtien = $giohangItems->sum('thanhtien');

        // 4. Truyền dữ liệu vào View
        return view('client.thanhtoan.giohang', compact('giohangItems', 'tongthanhtien'));
    }

    public function themgiohang(Request $request)
    {
        $request->validate([
            'id_bienthe' => 'required|exists:bienthe,id',
            'soluong' => 'required|integer|min:1',
        ]);

        $id_bienthe = $request->input('id_bienthe');
        $soluong_moi = $request->input('soluong');
        $id_nguoidung = Auth::id();
        
        $bienthe = BientheModel::with('sanpham')
        ->find($id_bienthe);
        if (!$bienthe || $bienthe->soluong < $soluong_moi) {
            return back()->with('error', 'Sản phẩm không hợp lệ hoặc không đủ số lượng.');
        }

        $giohangItem = GiohangModel::where('id_nguoidung', $id_nguoidung)
                                    ->where('id_bienthe', $id_bienthe)
                                    ->where('trangthai', 1)
                                    ->first();

        $giagoc = $bienthe->giagoc;
        $giadagiam = $bienthe->giagoc * (1 - $bienthe->sanpham->giamgia / 100);


        if ($giohangItem) {
            // Cập nhật số lượng và thành tiền
            $soluong_moi_tong = $giohangItem->soluong + $soluong_moi;
            
            // Kiểm tra lại số lượng tồn kho
            if ($bienthe->soluong < $soluong_moi_tong) {
                 return back()->with('error', 'Tổng số lượng vượt quá tồn kho.');
            }

            $giohangItem->soluong = $soluong_moi_tong;
            $giohangItem->thanhtien = $soluong_moi_tong * $giadagiam; 
            $giohangItem->save();
            $thongbao = 'Đã cập nhật số lượng trong giỏ hàng.';
        } else {
            // Thêm mới vào giỏ hàng
            GiohangModel::create([
                'id_bienthe' => $id_bienthe,
                'id_nguoidung' => $id_nguoidung,
                'soluong' => $soluong_moi,
                'thanhtien' => $soluong_moi * $giadagiam,
                'trangthai' => 'Hiển thị',
            ]);
            $thongbao = 'Đã thêm sản phẩm vào giỏ hàng.';
        }


        return redirect()->route('gio-hang')->with('success', $thongbao);
    }
}
