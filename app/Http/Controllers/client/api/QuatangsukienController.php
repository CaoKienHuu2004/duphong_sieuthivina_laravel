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
}