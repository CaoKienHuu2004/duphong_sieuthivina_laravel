<?php

namespace App\Http\Controllers\client;

use App\Http\Controllers\Controller;
use App\Models\BientheModel;
use App\Models\GiohangModel;
use App\Models\MagiamgiaModel;
use App\Models\NguoidungModel;
use App\Models\SanphamModel;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class GiohangController extends Controller
{
    public function index()
    {
        $id_nguoidung = Auth::id();

        // 1. Tải Giỏ hàng với Eager Loading
        $giohangItems = GiohangModel::with([
            'bienthe.sanpham',
            'bienthe.loaibienthe', 
            'bienthe.sanpham.hinhanhsanpham',
            'bienthe.sanpham.thuonghieu'
        ])
        ->where('id_nguoidung', $id_nguoidung)
        ->where('trangthai', 'Hiển thị') // Giả sử trạng thái là chuỗi 'Hiển thị'
        ->get();
        
        $tong_tien_hang = 0; // Tổng tiền hàng (sau khi giảm giá sản phẩm, trước khi trừ voucher)
        $tong_giam_gia_san_pham = 0; // Tổng số tiền giảm từ SP (giá gốc - giá bán)

        // 2. Lặp qua các Item để tính Đơn giá đã giảm và tổng hợp Thành tiền
        $giohangItems = $giohangItems->map(function ($item) use (&$tong_tien_hang, &$tong_giam_gia_san_pham) {
            $bienthe = $item->bienthe;
            
            $giaGocDonVi = $bienthe->giagoc;
            $giamGiaPhanTram = $bienthe->sanpham->giamgia ?? 0;
            
            $giaDaGiamDonVi = $giaGocDonVi; 

            if ($giamGiaPhanTram > 0) {
                $tyLeGiam = $giamGiaPhanTram / 100;
                $giaDaGiamTam = $giaGocDonVi * (1 - $tyLeGiam);
                $giaDaGiamDonVi = round($giaDaGiamTam);
            }
            
            // Tính số tiền giảm giá trên 1 đơn vị sản phẩm
            $giamGiaDonVi = $giaGocDonVi - $giaDaGiamDonVi;

            // Gán các thuộc tính mới cho View
            $item->gia_goc_don_vi = $giaGocDonVi;
            $item->gia_da_giam_don_vi = $giaDaGiamDonVi;

            // Cập nhật tổng tiền hàng (sau giảm giá sản phẩm)
            // Lưu ý: Cột 'thanhtien' đã được cập nhật chính xác trong hàm themgiohang/capnhatGiohang
            $tong_tien_hang += $item->thanhtien; 
            
            // Tổng số tiền giảm giá từ các sản phẩm
            $tong_giam_gia_san_pham += $giamGiaDonVi * $item->soluong;

            return $item;
        });

        // 3. Xử lý Voucher (Giảm giá tổng đơn hàng)
        $voucherInfo = session('voucher'); 
        $giam_gia_voucher = 0;
        $tong_cuoi_cung = $tong_tien_hang;

        if ($voucherInfo) {
            // Lấy giá trị giảm từ Session
            $giam_gia_voucher = $voucherInfo['giam_gia']; 
            
            // Tính tổng cuối cùng
            $tong_cuoi_cung = $tong_tien_hang - $giam_gia_voucher;
            if ($tong_cuoi_cung < 0) {
                $tong_cuoi_cung = 0; // Đảm bảo tổng không âm
            }
        }
        
        // 4. Tính tổng tiết kiệm
        $tong_tien_giam_duoc = $tong_giam_gia_san_pham + $giam_gia_voucher;

        // 5. Truyền dữ liệu vào View
        return view('client.thanhtoan.giohang', compact(
            'giohangItems', 
            'tong_tien_hang', // Tạm tính (sau giảm SP)
            'voucherInfo', 
            'giam_gia_voucher', // Giảm giá từ Voucher
            'tong_cuoi_cung', // Tổng tiền cần trả
            'tong_tien_giam_duoc' // Tổng tiết kiệm (SP + Voucher)
        ));
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

    public function capnhatsoluong(Request $request)
    {
        $request->validate([
            'id' => 'required|exists:giohang,id', // id của item trong giỏ hàng
            'soluong' => 'required|integer|min:1',
        ]);

        $id_item = $request->input('id');
        $soluong_moi = $request->input('soluong');
        $id_nguoidung = Auth::id();

        $giohangItem = GiohangModel::with('bienthe.sanpham') // Cần tải sp để tính giá
                                    ->where('id', $id_item)
                                    ->where('id_nguoidung', $id_nguoidung)
                                    ->where('trangthai', 1)
                                    ->first();

        if (!$giohangItem) {
            return response()->json(['nullerror' => false, 'message' => 'Mục giỏ hàng không tồn tại.'], 404);
        }

        $bienthe = $giohangItem->bienthe;
        if ($bienthe->soluong < $soluong_moi) {
            return response()->json(['stockerror' => false, 'message' => 'Số lượng vượt quá tồn kho.', 'ton_kho' => $bienthe->soluong], 400);
        }

        // 1. 💰 TÍNH LẠI GIÁ ĐÃ GIẢM (Đơn giá)
        $giaGoc = $bienthe->giagoc;
        $giamGiaPhanTram = $bienthe->sanpham->giamgia ?? 0; 
        $gia_sau_giam = $giaGoc;

        if ($giamGiaPhanTram > 0) {
            $tyLeGiam = $giamGiaPhanTram / 100;
            $gia_sau_giam = round($giaGoc * (1 - $tyLeGiam));
        }

        // 2. Cập nhật số lượng và Thành tiền cho Item hiện tại
        $giohangItem->soluong = $soluong_moi;
        $giohangItem->thanhtien = $soluong_moi * $gia_sau_giam;
        $giohangItem->save();

        // 3. Tính Tổng Giỏ hàng (Tổng tiền của TẤT CẢ các item)
        $tong_thanhtien_moi = GiohangModel::where('id_nguoidung', $id_nguoidung)
                                          ->where('trangthai', 1)
                                          ->sum('thanhtien');
        
        // 4. Trả về JSON để Client cập nhật giao diện
        return response()->json([
            'success' => true,
            'message' => 'Cập nhật giỏ hàng thành công.',
            'soluong_moi' => $soluong_moi,
            'thanh_tien_item_moi' => number_format($giohangItem->thanhtien), // Thành tiền của item hiện tại
            'tong_thanhtien_moi' => number_format($tong_thanhtien_moi),     // Tổng toàn bộ giỏ hàng
            'gia_don_vi' => number_format($gia_sau_giam),                   // Đơn giá đã giảm
        ]);
    }
}
