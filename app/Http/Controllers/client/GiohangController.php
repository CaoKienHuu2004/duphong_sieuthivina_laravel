<?php

namespace App\Http\Controllers\client;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Services\giohangService;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class GiohangController extends Controller
{
    protected $cartService;

    public function __construct(giohangService $cartService)
    {
        $this->middleware('auth');
        $this->cartService = $cartService;
    }

    // ========================================================================
    // HIỂN THỊ VÀ LẤY DATA
    // ========================================================================

    public function index()
    {
        return view('client.thanhtoan.giohang');
    }

    public function getCartDataAjax()
    {
        $data = $this->cartService->getCartData();
        return response()->json(['success' => true, 'data' => $data]);
    }

    // ========================================================================
    // TƯƠNG TÁC (AJAX ACTIONS)
    // ========================================================================

    public function themgiohang(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'id_bienthe' => 'required|integer|exists:bienthe,id',
            'soluong'    => 'required|integer|min:1',
        ]);

        if ($validator->fails()) {
            return response()->json(['success' => false, 'error' => $validator->errors()->first()], 400);
        }

        $result = $this->cartService->themVaoGio($request->id_bienthe, (int) $request->soluong);
        
        if (!$result) {
            return response()->json(['success' => false, 'error' => 'Sản phẩm không tồn tại hoặc số lượng tồn kho không đủ.'], 400);
        }

        return redirect()->route('gio-hang')->with('success', 'Đã thêm sản phẩm vào giỏ hàng.');
    }

    public function capnhatsoluong(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'id_bienthe' => 'required|integer|exists:bienthe,id',
            'soluong'    => 'required|integer|min:0',
        ]);
        
        if ($validator->fails()) {
            return response()->json(['success' => false, 'error' => $validator->errors()->first()], 400);
        }

        if ((int) $request->soluong === 0) {
            return $this->xoasanphamgiohang($request, $request->id_bienthe);
        }

        $result = $this->cartService->capNhatSoLuong($request->id_bienthe, (int) $request->soluong);

        if (!$result) {
            return response()->json(['success' => false, 'error' => 'Sản phẩm không tồn tại hoặc số lượng tồn kho không đủ.'], 400);
        }

        return response()->json(['success' => true, 'message' => 'Cập nhật giỏ hàng thành công.']);
    }

    public function xoasanphamgiohang(Request $request, $id)
    {
        $this->cartService->xoaSanPham($id);
        return response()->json(['success' => true, 'message' => 'Đã xóa sản phẩm khỏi giỏ hàng.']);
    }
    
    public function apdungvoucher(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'voucher_code' => 'required|string|max:50',
        ]);

        if ($validator->fails()) {
            // Trả về 200 OK cho lỗi Validation
            return response()->json(['success' => false, 'error' => $validator->errors()->first()], 200);
        }

        $code = trim($request->voucher_code);
        
        $result = $this->cartService->apDungVoucher($code);

        // LUÔN TRẢ VỀ 200 OK (Thành công hoặc Lỗi nghiệp vụ),
        // và để Frontend kiểm tra trường 'status' trong $result.
        if ($result['status'] === 'success') {
            return response()->json(['success' => true, 'message' => $result['message']]);
        } else {
            // Trả về lỗi nghiệp vụ (Voucher không hợp lệ/không đủ điều kiện)
            // nhưng sử dụng status HTTP 200 để tránh lỗi console
            return response()->json(['success' => false, 'error' => $result['message']]);
        }
    }


    public function xoavoucher()
    {
        $this->cartService->xoaVoucher();
        return response()->json(['success' => true, 'message' => 'Đã xóa mã giảm giá thành công!']);
    }
}