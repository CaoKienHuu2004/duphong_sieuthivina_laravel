<?php

namespace App\Http\Controllers\client\api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\GiohangModel;
use App\Models\BientheModel;
use App\Models\QuatangsukienModel;
use App\Models\SanphamthamgiaquatangModel;
use App\Models\SanphamduoctangquatangModel;
use App\Models\MagiamgiaModel;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;

class GiohangController extends Controller
{
    /**
     * 1. LẤY CHI TIẾT GIỎ HÀNG (Dùng để hiển thị trang giỏ hàng)
     * Tính toán động: Hàng mua + Quà tặng + Voucher + Tiết kiệm
     */
    public function getCartDetails(Request $request)
    {
        // Lấy hàng mua (Raw Items)
        $rawItems = $this->getRawCartItems($request);

        // Tính toán quà tặng dựa trên hàng mua
        $gifts = $this->calculateGifts($rawItems);

        // Hợp nhất mảng
        $fullCart = array_merge($rawItems, $gifts);

        // Tính toán tiền nong
        $tamtinh = collect($rawItems)->sum('thanhtien');
        $voucherData = $this->processVoucher($request->voucher_code, $tamtinh);
        $tonggiatri = max(0, $tamtinh - $voucherData['giam_gia']);
        $tietkiem = $this->calculateTotalSavings($fullCart) + $voucherData['giam_gia'];

        return response()->json([
            'status' => 200,
            'data' => [
                'items' => $this->formatCartResponse($fullCart),
                'summary' => [
                    'tamtinh' => $tamtinh,
                    'tietkiem' => $tietkiem,
                    'giamgia_voucher' => $voucherData['giam_gia'],
                    'tonggiatri' => $tonggiatri,
                    'voucher_info' => $voucherData['voucher']
                ],
                'available_vouchers' => $this->getAvailableVouchers($tamtinh)
            ]
        ]);
    }

    /**
     * 2. THÊM VÀO GIỎ HÀNG
     */
    public function themgiohang(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'id_bienthe' => 'required|exists:bienthe,id',
            'soluong' => 'required|integer|min:1',
            'cart_local' => 'nullable|array' 
        ]);

        if ($validator->fails()) return response()->json(['status' => 422, 'errors' => $validator->errors()], 422);

        $bienthe = BientheModel::with(['sanpham.hinhanhsanpham', 'loaibienthe'])->find($request->id_bienthe);
        $soluong_daco = 0;

        if (Auth::guard('sanctum')->check()) {
            $item_db = GiohangModel::where('id_nguoidung', Auth::guard('sanctum')->id())
                ->where('id_bienthe', $request->id_bienthe)->where('thanhtien', '>', 0)->first();
            $soluong_daco = $item_db ? $item_db->soluong : 0;
        } else {
            foreach ($request->cart_local ?? [] as $item) {
                if (($item['id_bienthe'] ?? 0) == $request->id_bienthe) { $soluong_daco = $item['soluong']; break; }
            }
        }

        if (($soluong_daco + $request->soluong) > $bienthe->soluong) {
            return response()->json(['status' => 400, 'message' => "Tồn kho không đủ."], 400);
        }

        if (Auth::guard('sanctum')->check()) {
            $newQty = $soluong_daco + $request->soluong;
            GiohangModel::updateOrCreate(
                ['id_nguoidung' => Auth::guard('sanctum')->id(), 'id_bienthe' => $request->id_bienthe, 'thanhtien' => ['>', 0]],
                ['soluong' => $newQty, 'thanhtien' => $newQty * $bienthe->giadagiam, 'trangthai' => 'Hiển thị']
            );
            return response()->json(['status' => 200, 'message' => 'Đã cập nhật giỏ hàng hệ thống.']);
        }

        return response()->json([
            'status' => 201,
            'item' => [
                'id_bienthe' => $bienthe->id,
                'soluong' => $soluong_daco + $request->soluong,
                'giaban' => $bienthe->giadagiam,
                'ten_sp' => $bienthe->sanpham->ten,
                'ten_bt' => $bienthe->loaibienthe->ten ?? '',
                'hinhanh' => $bienthe->sanpham->hinhanhsanpham->first() ? asset('assets/client/images/thumbs/' . $bienthe->sanpham->hinhanhsanpham->first()->hinhanh) : null
            ]
        ]);
    }

    /**
     * 3. ĐỒNG BỘ GIỎ HÀNG (Sync)
     */
    public function syncCart(Request $request)
    {
        $validator = Validator::make($request->all(), ['cart_items' => 'required|array']);
        if ($validator->fails()) return response()->json(['status' => 422, 'message' => 'Dữ liệu không hợp lệ.'], 422);

        $userId = Auth::guard('sanctum')->id();
        DB::transaction(function () use ($request, $userId) {
            foreach ($request->cart_items as $item) {
                $bienthe = BientheModel::find($item['id_bienthe']);
                if ($bienthe) {
                    $existing = GiohangModel::where('id_nguoidung', $userId)->where('id_bienthe', $item['id_bienthe'])->where('thanhtien', '>', 0)->first();
                    $finalQty = min(($existing ? $existing->soluong : 0) + $item['soluong'], $bienthe->soluong);
                    GiohangModel::updateOrCreate(
                        ['id_nguoidung' => $userId, 'id_bienthe' => $item['id_bienthe'], 'thanhtien' => ['>', 0]],
                        ['soluong' => $finalQty, 'thanhtien' => $finalQty * $bienthe->giadagiam, 'trangthai' => 'Hiển thị']
                    );
                }
            }
        });
        return response()->json(['status' => 200, 'message' => 'Đồng bộ thành công!']);
    }

    /**
     * 4. XÓA SẢN PHẨM (Chỉ dành cho Auth, Guest tự xóa ở Local)
     */
    public function xoagiohang($id_bienthe)
    {
        GiohangModel::where('id_nguoidung', Auth::guard('sanctum')->id())
            ->where('id_bienthe', $id_bienthe)->delete();
        return response()->json(['status' => 200, 'message' => 'Đã xóa sản phẩm.']);
    }

    // --- CÁC HÀM TRỢ GIÚP LOGIC ---

    private function getRawCartItems(Request $request) {
        if (Auth::guard('sanctum')->check()) {
            return GiohangModel::with(['bienthe.sanpham.thuonghieu', 'bienthe.sanpham.hinhanhsanpham', 'bienthe.loaibienthe'])
                ->where('id_nguoidung', Auth::guard('sanctum')->id())->where('thanhtien', '>', 0)->get()
                ->map(fn($item) => ['id_bienthe' => $item->id_bienthe, 'soluong' => $item->soluong, 'thanhtien' => $item->thanhtien, 'bienthe' => $item->bienthe])
                ->toArray();
        }
        $items = [];
        foreach ($request->cart_local ?? [] as $item) {
            $bt = BientheModel::with(['sanpham.thuonghieu', 'sanpham.hinhanhsanpham', 'loaibienthe'])->find($item['id_bienthe']);
            if ($bt) $items[] = ['id_bienthe' => $bt->id, 'soluong' => $item['soluong'], 'thanhtien' => $item['soluong'] * $bt->giadagiam, 'bienthe' => $bt];
        }
        return $items;
    }

    private function calculateGifts($rawItems) {
        $gifts = [];
        $cartTotalValue = collect($rawItems)->sum('thanhtien');
        $rules = QuatangsukienModel::where('trangthai', 'Hiển thị')->where('ngaybatdau', '<=', now())->where('ngayketthuc', '>=', now())->get();

        foreach ($rules as $rule) {
            if ($cartTotalValue < ($rule->dieukiengiatri ?? 0)) continue;
            $reqIds = SanphamthamgiaquatangModel::where('id_quatang', $rule->id)->pluck('id_bienthe')->toArray();
            $matchQty = 0;
            if (count($reqIds) > 0) {
                foreach ($rawItems as $i) { if (in_array($i['id_bienthe'], $reqIds)) $matchQty += $i['soluong']; }
                $suat = floor($matchQty / $rule->dieukiensoluong);
            } else { $suat = 1; }

            if ($suat > 0) {
                foreach (SanphamduoctangquatangModel::where('id_quatang', $rule->id)->get() as $q) {
                    $btG = BientheModel::with(['sanpham.thuonghieu', 'sanpham.hinhanhsanpham', 'loaibienthe'])->find($q->id_bienthe);
                    if ($btG && $btG->soluong >= ($q->soluongtang * $suat)) {
                        $gifts[] = ['id_bienthe' => $btG->id, 'soluong' => $q->soluongtang * $suat, 'thanhtien' => 0, 'is_gift' => true, 'bienthe' => $btG];
                    }
                }
            }
        }
        return $gifts;
    }

    private function processVoucher($code, $tamtinh) {
        if (!$code) return ['giam_gia' => 0, 'voucher' => null];
        $v = MagiamgiaModel::where('magiamgia', strtoupper($code))->where('trangthai', 'Hoạt động')->where('dieukien', '<=', $tamtinh)->first();
        return $v ? ['giam_gia' => min($v->giatri, $tamtinh), 'voucher' => $v] : ['giam_gia' => 0, 'voucher' => null];
    }

    private function calculateTotalSavings($items) {
        return collect($items)->sum(fn($i) => ($i['thanhtien'] == 0) ? $i['bienthe']['giagoc'] * $i['soluong'] : ($i['bienthe']['giagoc'] - $i['bienthe']['giadagiam']) * $i['soluong']);
    }

    private function formatCartResponse($items) {
        foreach ($items as &$i) {
            if (isset($i['bienthe']['sanpham']['hinhanhsanpham'])) {
                foreach ($i['bienthe']['sanpham']['hinhanhsanpham'] as &$img) { $img['hinhanh'] = asset('assets/client/images/thumbs/' . $img['hinhanh']); }
            }
        }
        return $items;
    }

    private function getAvailableVouchers($tamtinh) {
        return MagiamgiaModel::where('trangthai', 'Hoạt động')->where('dieukien', '<=', $tamtinh)->get();
    }
}