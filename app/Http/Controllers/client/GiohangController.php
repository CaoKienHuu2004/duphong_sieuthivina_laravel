<?php

namespace App\Http\Controllers\client;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\GiohangModel;
use App\Models\BientheModel;
use App\Models\MagiamgiaModel;
use App\Models\NguoidungModel;
use App\Models\QuatangsukienModel;
use Carbon\Carbon;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Session;

class GiohangController extends Controller
{
    public function index()
    {
        return view('client.thanhtoan.giohang');
    }

    public function themgiohang(Request $request)
    {
        // 1. Validate dữ liệu đầu vào
        $request->validate([
            'id_bienthe' => 'required|exists:bienthe,id',
            'soluong' => 'required|integer|min:1',
        ]);

        $id_bienthe = $request->input('id_bienthe');
        $soluong_them = $request->input('soluong');

        // Lấy thông tin biến thể VÀ eagerly load sanpham
        $bienthe = BientheModel::with('sanpham')->find($id_bienthe); 
        
        if (!$bienthe) {
            // Trả về JSON nếu là AJAX request
            return response()->json(['status' => 'error', 'message' => 'Biến thể sản phẩm không tồn tại.'], 404);
        }

        $giaban = $bienthe->giadagiam; // Giá đã giảm (Accessor)
        $tonkho_hientai = $bienthe->soluong; // Số lượng tồn kho
        $soluong_daco = 0; 
        $cart = Session::get('cart', []); // Khởi tạo cart cho Guest

        // --- 2. XÁC ĐỊNH SỐ LƯỢNG ĐÃ CÓ VÀ KIỂM TRA TỒN KHO ---
        if (Auth::check()) {
            // AUTH: Kiểm tra trong Database
            $id_nguoidung = Auth::id();
            $giohang_item_db = GiohangModel::where('id_nguoidung', $id_nguoidung)
                                          ->where('id_bienthe', $id_bienthe)
                                          ->first();
            if ($giohang_item_db) {
                $soluong_daco = $giohang_item_db->soluong;
            }
        } else {
            // GUEST: Kiểm tra trong Session
            if (isset($cart[$id_bienthe])) {
                $soluong_daco = $cart[$id_bienthe]['soluong'];
            }
        }
        
        $tong_soluong_moi = $soluong_daco + $soluong_them;

        if ($tong_soluong_moi > $tonkho_hientai) {
             $con_lai = $tonkho_hientai - $soluong_daco;
             $message_error = "Xin lỗi, số lượng tồn kho chỉ còn $tonkho_hientai sản phẩm. Bạn chỉ có thể thêm tối đa $con_lai sản phẩm nữa.";
             
             // Trả về JSON lỗi tồn kho
             return response()->json([
                 'status' => 'error', 
                 'message' => $message_error, 
                 'con_lai' => max(0, $con_lai)
             ], 400); // Bad Request
        }
        
        // --- 3. TIẾN HÀNH THÊM HOẶC CẬP NHẬT GIỎ HÀNG ---
        
        if (Auth::check()) {
            // 3a. ĐÃ ĐĂNG NHẬP (Lưu vào Database)
            if (isset($giohang_item_db)) {
                // Cập nhật
                $giohang_item_db->soluong = $tong_soluong_moi;
                $giohang_item_db->thanhtien = $tong_soluong_moi * $giaban;
                $giohang_item_db->save();
                $message = 'Đã cập nhật số lượng sản phẩm trong giỏ hàng!';
                
            } else {
                // Thêm mới
                $giohang_item_db = GiohangModel::create([
                    'id_nguoidung' => $id_nguoidung,
                    'id_bienthe' => $id_bienthe,
                    'soluong' => $soluong_them,
                    'thanhtien' => $soluong_them * $giaban,
                    'trangthai' => 'Hiển thị',
                ]);
                $message = 'Đã thêm sản phẩm vào giỏ hàng !';
            }
            // Không trả về $cart (Session) trong trường hợp Auth, mà trả về Database Cart hoặc thông báo.
            $data_response = $giohang_item_db; // Có thể trả về item vừa được tạo/cập nhật

        } else {
            // 3b. CHƯA ĐĂNG NHẬP (Lưu vào Session)
            if (isset($cart[$id_bienthe])) {
                // Cập nhật
                $cart[$id_bienthe]['soluong'] = $tong_soluong_moi;
                $cart[$id_bienthe]['giaban'] = $giaban; // Cập nhật lại giá
                $cart[$id_bienthe]['thanhtien'] = $tong_soluong_moi * $giaban; 
                $message = 'Đã cập nhật số lượng sản phẩm trong giỏ hàng !';
            } else {
                // Thêm mới
                $cart[$id_bienthe] = [
                    'id_bienthe' => $id_bienthe,
                    'soluong' => $soluong_them,
                    'giaban' => $giaban, // <-- THÊM THUỘC TÍNH GIÁ BÁN
                    'thanhtien' => $soluong_them * $giaban,
                    'trangthai' => 'Hiển thị',
                ];
                $message = 'Đã thêm sản phẩm vào giỏ hàng !';
            }

            Session::put('cart', $cart); // Lưu lại Session
            $data_response = $cart; // Trả về toàn bộ Session Cart
        }
        
        return redirect()->route('gio-hang')->with([
            'status' => 'success', 
            'message' => $message 
        ]);
        
        // Hoặc đơn giản hơn, nếu Route hiển thị trang giỏ hàng là /gio-hang:
        // return redirect('/gio-hang')->with([
        //     'status' => 'success', 
        //     'message' => $message 
        // ]);
    }
    

}