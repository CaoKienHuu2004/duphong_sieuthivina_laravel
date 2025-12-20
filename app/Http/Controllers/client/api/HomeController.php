<?php

namespace App\Http\Controllers\client\api;

use App\Http\Controllers\Controller;
use App\Models\QuangcaoModel;
use App\Models\DanhmucModel;
use App\Models\SanphamModel;
use App\Models\QuatangsukienModel;
use App\Models\ThuonghieuModel;
use App\Models\BientheModel;
use App\Http\Resources\SanphamResource;
use Illuminate\Http\Request;

class HomeController extends Controller
{

    /**
     * @OA\Get(
     * path="/trang-chu",
     * tags={"Trang chủ"},
     * summary="Lấy toàn bộ dữ liệu hiển thị trang chủ",
     * description="Trả về Banner, Danh mục, Top Deals, Quà tặng, Sản phẩm hàng đầu...",
     * @OA\Response(
     * response=200,
     * description="Thành công"
     * )
     * )
     */
    public function index()
    {
        return response()->json([
            'status' => 200,
            'banners' => $this->banner(),
            'tatcadanhmuc' => $this->alldanhmuc(),
            'top_deals' => SanphamResource::collection($this->topdeals()),
            'chuongtrinhuudaiquatang' => $this->quatang(),
            'danhmuchangdau' => $this->danhmuchangdau(),
            'thuonghieuhangdau' => $this->thuonghieuhangdau(),
            'sanphamhangdau' => SanphamResource::collection($this->sanphamhangdau()),
            'hangmoichaosan' => SanphamResource::collection($this->hangmoichaosan()),
            'duocquantamnhieunhat' => SanphamResource::collection($this->cothebanyeuthich()),
        ]);
    }

    // 1. Banner slider & cố định
    protected function banner() {
        return QuangcaoModel::where('trangthai', 'Hiển thị')
            ->get()
            ->map(function($item) {
                $item->hinhanh = asset('assets/client/images/bg/' . $item->hinhanh);
                return $item;
            })
            ->groupBy('vitri'); 
    }

    // 2. Danh sách danh mục
    protected function alldanhmuc() {
        return DanhmucModel::where('trangthai', 'Hiển thị')->orderBy('sapxep', 'asc')->get()->map(function($item) {
            $item->logo = asset('assets/client/images/categories/' . $item->logo);
            return $item;
        });
    }

    // 3. Sản phẩm tham gia quà tặng
    protected function topdeals() {
        return SanphamModel::where('trangthai', 'Công khai')
            ->whereHas('bienthe', function($q) {
                $q->whereIn('id', fn($sq) => $sq->select('id_bienthe')->from('sanphamthamgia_quatang'));
            })
            ->with(['hinhanhsanpham', 'bienthe'])->withSum('bienthe', 'luotban')
            ->orderByDesc('bienthe_sum_luotban')->limit(10)->get();
    }

    // 4. Chương trình quà tặng
    protected function quatang() {
        return QuatangsukienModel::where('trangthai', 'Hiển thị')
            ->where('ngaybatdau', '<=', now())
            ->where('ngayketthuc', '>=', now())
            ->orderByDesc('luotxem')->limit(10)->get();
    }

    // 5. Danh mục hàng đầu + Sản phẩm thuộc danh mục đó
    protected function danhmuchangdau()
{
    // 1. Lấy Top 5 danh mục bán chạy nhất (Logic gốc)
    $topCategorySales = BientheModel::whereIn('bienthe.trangthai', ['Còn hàng', 'Sắp hết hàng'])
        ->whereNull('bienthe.deleted_at')
        ->join('sanpham', 'bienthe.id_sanpham', '=', 'sanpham.id')
        ->join('danhmuc_sanpham', 'sanpham.id', '=', 'danhmuc_sanpham.id_sanpham')
        ->select('danhmuc_sanpham.id_danhmuc')
        ->selectRaw('SUM(bienthe.luotban) as total_sales')
        ->groupBy('danhmuc_sanpham.id_danhmuc')
        ->orderByDesc('total_sales')
        ->limit(5)
        ->get();

    $topCategoryIds = $topCategorySales->pluck('id_danhmuc')->toArray();

    // 2. Lấy danh sách thông tin danh mục & Xử lý URL hình ảnh
    $topCategoriesList = DanhmucModel::whereIn('id', $topCategoryIds)
        ->get()
        ->map(function($dm) {
            if($dm->hinhanh) {
                $dm->hinhanh = asset('assets/client/images/thumbs/' . $dm->hinhanh);
            }
            return $dm;
        })
        ->sortBy(function ($category) use ($topCategorySales) {
            $salesData = $topCategorySales->firstWhere('id_danhmuc', $category->id);
            return $salesData ? $salesData->total_sales : 0;
        }, SORT_REGULAR, true)
        ->values(); // Reset key mảng để trả về JSON dạng [{}, {}]

    $topProductsByCategory = collect();

    // 3. Lấy sản phẩm cho từng danh mục
    foreach ($topCategoryIds as $categoryId) {
        $products = SanphamModel::with(['hinhanhsanpham', 'thuonghieu', 'danhmuc', 'bienthe.loaibienthe'])
            ->whereHas('danhmuc', function ($query) use ($categoryId) {
                $query->where('id_danhmuc', $categoryId);
            })
            ->join('bienthe', 'sanpham.id', '=', 'bienthe.id_sanpham')
            ->select('sanpham.*')
            ->selectRaw('SUM(bienthe.luotban) as product_total_sales')
            ->whereIn('bienthe.trangthai', ['Còn hàng', 'Sắp hết hàng'])
            ->whereNull('sanpham.deleted_at')
            ->whereNull('bienthe.deleted_at')
            ->groupBy('sanpham.id')
            ->orderByDesc('product_total_sales')
            ->limit(12)
            ->get()
            ->each(function ($sanpham) {
                // Xử lý biến thể rẻ nhất & tính giá đã giảm
                if ($sanpham->bienthe->isNotEmpty()) {
                    $cheapestVariant = $sanpham->bienthe->sortBy('giagoc')->first();
                    $sanpham->bienthe_display = $cheapestVariant; // Gán vào thuộc tính mới để tránh mất collection bienthe
                    
                    $giagoc = $cheapestVariant->giagoc;
                    $sanpham->giadagiam = $giagoc * (1 - ($sanpham->giamgia / 100));
                }

                // Chuyển đổi toàn bộ mảng hình ảnh sản phẩm thành URL tuyệt đối
                $sanpham->hinhanhsanpham->each(function($img) {
                    $img->hinhanh = asset('assets/client/images/thumbs/' . $img->hinhanh);
                });
            });

        $topProductsByCategory->put($categoryId, $products);
    }

    return [
        'danhsachdmhangdau' => $topCategoriesList,
        'sanphamthuocdanhmuc' => $topProductsByCategory,
    ];
}

    // 6. Thương hiệu hàng đầu
    protected function thuonghieuhangdau() {
        return ThuonghieuModel::withCount('sanpham')
            ->orderByDesc('sanpham_count')->limit(5)->get();
    }

    // 7. Sản phẩm bán chạy
    protected function sanphamhangdau() {
        return SanphamModel::where('trangthai', 'Công khai')
            ->withSum('bienthe', 'luotban')
            ->orderByDesc('bienthe_sum_luotban')->limit(10)->get();
    }

    // 8. Sản phẩm mới
    protected function hangmoichaosan() {
        return SanphamModel::where('trangthai', 'Công khai')
        ->orderBy('id', 'desc') // Sắp xếp theo ID mới nhất
        ->limit(18)
        ->get();
    }

    // 9. Sản phẩm yêu thích (Xem nhiều)
    protected function cothebanyeuthich() {
        return SanphamModel::where('trangthai', 'Công khai')
            ->orderByDesc('luotxem')->limit(18)->get();
    }
}