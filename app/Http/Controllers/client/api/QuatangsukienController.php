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
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;

class QuatangsukienController extends Controller
{
    /**
     * Danh sách quà tặng: Load kèm chi tiết Thương hiệu và Hình ảnh
     */
    public function index(Request $request)
    {
        // Tự động cập nhật trạng thái nếu hết quà
        QuatangsukienModel::where('trangthai', 'Hiển thị')
            ->whereDoesntHave('sanphamduoctang', function (Builder $query) {
                $query->where('luottang', '>', 0);
            })->update(['trangthai' => 'Tạm ẩn']);

        $query = QuatangsukienModel::with([
            'sanphamduoctang.sanpham.thuonghieu',
            'sanphamduoctang.sanpham.hinhanhsanpham',
            'sanphamduoctang.loaibienthe' // Khai rõ loại biến thể (Hộp, gói, vỉ...)
        ])
            ->where('trangthai', 'Hiển thị')
            ->where('deleted_at', null);

        // Lọc & Sắp xếp (giữ nguyên logic)
        if ($request->filled('provider')) {
            $query->whereHas('sanphamduoctang.sanpham', function ($q) use ($request) {
                $q->where('id_thuonghieu', $request->provider);
            });
        }

        $sort = $request->input('sort', 'popular');
        switch ($sort) {
            case 'newest':
                $query->orderBy('ngaybatdau', 'desc');
                break;
            case 'expiring':
                $query->where('ngayketthuc', '>=', now())->orderBy('ngayketthuc', 'asc');
                break;
            default:
                $query->orderBy('luotxem', 'desc');
                break;
        }

        $quatang = $query->paginate(12);

        // Chuyển đổi tên file thành URL cho từng item trong danh sách
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
     * Chi tiết: Load đầy đủ ParticipatingProducts thay vì chỉ trả ID
     */
    public function show(Request $request, $slug)
    {
        $quatang = QuatangsukienModel::with([
            'sanphamduoctang.sanpham.thuonghieu',
            'sanphamduoctang.sanpham.hinhanhsanpham',
            'sanphamduoctang.loaibienthe'
        ])->where('slug', $slug)->firstOrFail();

        // Khai báo sản phẩm khách PHẢI MUA (Full thông tin cho FE)
        $participatingProducts = BientheModel::with([
            'sanpham.thuonghieu',
            'sanpham.hinhanhsanpham',
            'loaibienthe'
        ])
            ->whereHas('sanphamthamgia', fn($q) => $q->where('id_quatang', $quatang->id))
            ->get();

        $participatingIds = $participatingProducts->pluck('id')->toArray();
        $representativeGift = $quatang->sanphamduoctang->first();
        $requiredBrandId = $representativeGift->sanpham->id_thuonghieu;

        // Tính toán tiến độ giỏ hàng
        $cartData = Auth::guard('sanctum')->check()
            ? GiohangModel::where('id_nguoidung', Auth::guard('sanctum')->id())->where('thanhtien', '>', 0)->get()
            : (is_string($request->cart_items) ? json_decode($request->cart_items, true) : ($request->cart_items ?? []));

        $metrics = $this->calculateCartMetrics($participatingIds, $requiredBrandId, $cartData);

        // Gợi ý sản phẩm liên quan (Full thông tin)
        $suggestedProducts = BientheModel::with(['sanpham.thuonghieu', 'sanpham.hinhanhsanpham', 'loaibienthe'])
            ->whereIn('trangthai', ['Còn hàng', 'Sắp hết hàng'])->where('soluong', '>', 0)
            ->when(
                count($participatingIds) > 0,
                fn($q) => $q->whereIn('id', $participatingIds),
                fn($q) => $q->whereHas('sanpham', fn($sq) => $sq->where('id_thuonghieu', $requiredBrandId))
            )->inRandomOrder()->take(10)->get();

        return response()->json([
            'status' => 200,
            'quatang' => $quatang,
            'sanphamthamgia' => $participatingProducts,
            'progress' => [
                'percent' => round($this->calcPercent($quatang, $metrics), 2),
                'currentCount' => $metrics['count'],
                'targetCount' => $quatang->dieukiensoluong,
                'currentValue' => $metrics['totalValue'],
                'targetValue' => $quatang->dieukiengiatri ?? 0,
            ],
        ]);
    }

    private function calculateCartMetrics($pIds, $brandId, $cartItems)
    {
        $count = 0;
        $total = 0;
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
