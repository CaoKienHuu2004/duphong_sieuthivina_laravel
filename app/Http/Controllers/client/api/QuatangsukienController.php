<?php

namespace App\Http\Controllers\client\api;

use App\Http\Controllers\Controller;
use App\Models\QuatangsukienModel;
use App\Models\ThuonghieuModel;
use App\Models\BientheModel;
use App\Models\GiohangModel;
use App\Models\SanphamthamgiaquatangModel;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Builder;

class QuatangsukienController extends Controller
{
    /**
     * Danh sách chương trình quà tặng (Index)
     */
    public function index(Request $request)
    {
        // Tự động ẩn chương trình hết quà
        QuatangsukienModel::where('trangthai', 'Hiển thị')
            ->whereDoesntHave('sanphamduoctang', function (Builder $query) {
                $query->where('luottang', '>', 0);
            })->update(['trangthai' => 'Tạm ẩn']);

        $query = QuatangsukienModel::with([
            'sanphamduoctang.sanpham.thuonghieu',
            'sanphamduoctang.sanpham.hinhanhsanpham',
            'sanphamduoctang.loaibienthe'
        ])
        ->where('trangthai', 'Hiển thị')
        ->where('deleted_at', null);

        // Lọc & Sắp xếp
        if ($request->filled('provider')) {
            $query->whereHas('sanphamduoctang.sanpham', fn($q) => $q->where('id_thuonghieu', $request->provider));
        }

        $sort = $request->input('sort', 'popular');
        switch ($sort) {
            case 'newest': $query->orderBy('ngaybatdau', 'desc'); break;
            case 'expiring': $query->where('ngayketthuc', '>=', now())->orderBy('ngayketthuc', 'asc'); break;
            default: $query->orderBy('luotxem', 'desc'); break;
        }

        $quatang = $query->paginate(12);

        // Chuẩn hóa URL ảnh
        $quatang->getCollection()->transform(function ($item) {
            if ($item->hinhanh) {
                $item->hinhanh = asset('assets/client/images/thumbs/' . $item->hinhanh);
            }
            return $item;
        });

        return response()->json([
            'status' => 200,
            'data' => $quatang,
            'providers' => ThuonghieuModel::whereHas('sanpham.bienthe.sanphamduoctang', fn($q) => $q->where('trangthai', 'Hiển thị'))->get()
        ]);
    }

    /**
     * Chi tiết chương trình: Trả về Quà tặng + Sản phẩm tham gia + Tiến độ
     */
    public function show(Request $request, $slug)
    {
        $quatang = QuatangsukienModel::with([
            'sanphamduoctang.sanpham.thuonghieu',
            'sanphamduoctang.sanpham.hinhanhsanpham',
            'sanphamduoctang.loaibienthe'
        ])->where('slug', $slug)->firstOrFail();

        // 1. Chuẩn hóa ảnh Banner sự kiện
        if ($quatang->hinhanh) {
            $quatang->hinhanh = asset('assets/client/images/thumbs/' . $quatang->hinhanh);
        }

        // 2. Lấy danh sách SẢN PHẨM THAM GIA (Khách phải mua)
        $participatingProducts = BientheModel::with(['sanpham.thuonghieu', 'sanpham.hinhanhsanpham', 'loaibienthe'])
            ->whereHas('sanphamthamgia', fn($q) => $q->where('id_quatang', $quatang->id))
            ->get()
            ->each(function($variant) {
                $variant->sanpham->hinhanhsanpham->each(function($img) {
                    $img->hinhanh = asset('assets/client/images/thumbs/' . $img->hinhanh);
                });
            });

        $participatingIds = $participatingProducts->pluck('id')->toArray();
        $representativeGift = $quatang->sanphamduoctang->first();
        $requiredBrandId = $representativeGift->sanpham->id_thuonghieu;

        // 3. Lấy dữ liệu giỏ hàng để tính toán (Auth DB hoặc localStorage gửi lên)
        $cartData = Auth::guard('sanctum')->check()
            ? GiohangModel::where('id_nguoidung', Auth::guard('sanctum')->id())->where('thanhtien', '>', 0)->get()
            : (is_string($request->cart_items) ? json_decode($request->cart_items, true) : ($request->cart_items ?? []));

        $metrics = $this->calculateCartMetrics($participatingIds, $requiredBrandId, $cartData);

        $quatang->increment('luotxem');

        return response()->json([
            'status' => 200,
            'quatang' => $quatang, // Trong này đã có sanphamduoctang (Quà tặng)
            'sanphamthamgia' => $participatingProducts, // Sản phẩm điều kiện
            'progress' => [
                'percent' => round($this->calcPercent($quatang, $metrics), 2),
                'currentCount' => $metrics['count'],
                'targetCount' => (int)$quatang->dieukiensoluong,
                'currentValue' => $metrics['totalValue'],
                'targetValue' => (float)($quatang->dieukiengiatri ?? 0),
            ],
        ]);
    }

    private function calculateCartMetrics($pIds, $brandId, $cartItems)
    {
        $count = 0; $total = 0;
        foreach ($cartItems as $item) {
            $item = (object) $item;
            $bt = BientheModel::with('sanpham')->find($item->id_bienthe ?? null);
            if (!$bt) continue;
            $isEligible = count($pIds) > 0 ? in_array($bt->id, $pIds) : ($bt->sanpham->id_thuonghieu == $brandId);
            if ($isEligible) {
                $count += $item->soluong;
                $total += $item->thanhtien ?? ($item->soluong * $bt->giadagiam);
            }
        }
        return ['count' => $count, 'totalValue' => $total];
    }

    private function calcPercent($q, $m)
    {
        $pCount = $q->dieukiensoluong > 0 ? ($m['count'] / $q->dieukiensoluong) * 100 : 100;
        $pValue = ($q->dieukiengiatri ?? 0) > 0 ? ($m['totalValue'] / $q->dieukiengiatri) * 100 : 100;
        return min(100, min($pCount, $pValue));
    }

    /**
     * Đồng bộ giỏ hàng từ localStorage lên Database sau khi đăng nhập
     */
    public function syncCart(Request $request)
    {
        // Kiểm tra user đã đăng nhập qua Sanctum chưa
        $user = Auth::guard('sanctum')->user();
        if (!$user) {
            return response()->json(['status' => 401, 'message' => 'Vui lòng đăng nhập để đồng bộ.'], 401);
        }

        // Nhận mảng giỏ hàng từ FE (localStorage)
        $cartItems = $request->input('cart_items', []); 

        if (empty($cartItems)) {
            return response()->json(['status' => 200, 'message' => 'Giỏ hàng trống, không có gì để đồng bộ.']);
        }

        try {
            DB::beginTransaction();

            foreach ($cartItems as $item) {
                $id_bienthe = $item['id_bienthe'] ?? null;
                $soluong_sync = $item['soluong'] ?? 0;

                if (!$id_bienthe || $soluong_sync <= 0) continue;

                $bienthe = BientheModel::find($id_bienthe);
                if (!$bienthe) continue;

                // Sử dụng updateOrCreate để cộng dồn nếu sản phẩm đã tồn tại trong DB của user
                // Chỉ xử lý các dòng có thanhtien > 0 (hàng mua)
                $giohangItem = GiohangModel::where('id_nguoidung', $user->id)
                    ->where('id_bienthe', $id_bienthe)
                    ->where('thanhtien', '>', 0)
                    ->first();

                if ($giohangItem) {
                    // Nếu đã có trong DB: Cộng dồn số lượng và tính lại thành tiền
                    $moi_soluong = $giohangItem->soluong + $soluong_sync;
                    // Kiểm tra tồn kho trước khi cộng dồn
                    if ($moi_soluong > $bienthe->soluong) $moi_soluong = $bienthe->soluong;

                    $giohangItem->update([
                        'soluong' => $moi_soluong,
                        'thanhtien' => $moi_soluong * $bienthe->giadagiam
                    ]);
                } else {
                    // Nếu chưa có: Tạo mới
                    if ($soluong_sync > $bienthe->soluong) $soluong_sync = $bienthe->soluong;
                    
                    GiohangModel::create([
                        'id_nguoidung' => $user->id,
                        'id_bienthe' => $id_bienthe,
                        'soluong' => $soluong_sync,
                        'thanhtien' => $soluong_sync * $bienthe->giadagiam,
                        'trangthai' => 'Hiển thị'
                    ]);
                }
            }

            DB::commit();
            return response()->json(['status' => 200, 'message' => 'Đồng bộ giỏ hàng thành công.']);

        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['status' => 500, 'message' => 'Có lỗi xảy ra khi đồng bộ.'], 500);
        }
    }
}