<?php



namespace App\Http\Controllers\client;

use App\Http\Controllers\Controller;
use App\Models\BientheModel;
use App\Models\DanhmucModel;
use App\Models\QuangcaoModel;
use App\Models\QuatangsukienModel;
use App\Models\SanphamModel;
use App\Models\ThuonghieuModel;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;


class HomeController extends Controller
{


    public function index()
    {
        $banner = $this->banner();
        $alldanhmuc = $this->alldanhmuc();
        $topdeals = $this->topdeals();
        $quatang = $this->quatang();
        $topCategoriesResult = $this->danhmuchangdau();
        $danhsachdmhangdau = $topCategoriesResult['danhsachdmhangdau'];
        $sanphamthuocdanhmuc = $topCategoriesResult['sanphamthuocdanhmuc'];
        $topbrands = $this->thuonghieuhangdau();
        $topproducts = $this->sanphamhangdau();
        $hangmoichaosan = $this->hangmoichaosan();
        $likeProducts = $this->cothebanyeuThich();

        // return response()->json([
        //     'banner' => $banner,
        //     'alldanhmuc' => $alldanhmuc,
        //     'topdeals' => $topdeals,
        //     'quatang' => $quatang,
        //     'danhsachdmhangdau' => $danhsachdmhangdau,
        //     'sanphamthuocdanhmuc' => $sanphamthuocdanhmuc,
        // ]);
        return view('client.index', compact(
            'banner',
            'alldanhmuc',
            'topdeals',
            'quatang',
            'danhsachdmhangdau',
            'sanphamthuocdanhmuc',
            'topbrands',
            'topproducts',
            'hangmoichaosan',
            'likeProducts'
        ));
    }

    protected function banner()
    {
        $allBanners = QuangcaoModel::where('trangthai', 'Hiển thị')->get();
        $bannersByPosition = $allBanners->groupBy('vitri')->map(function ($banners, $position) {
            if ($position === 'home_banner_slider') {
                return $banners;
            }
            return $banners->first();
        });
        return $bannersByPosition->all();
    }

    protected function alldanhmuc()
    {
        $alldanhmuc = DanhmucModel::where('trangthai', 'Hiển thị')
            ->orderBy('sapxep', 'asc')
            ->get();
        return $alldanhmuc;
    }

    protected function topdeals()
    {
        // Lấy thời điểm hiện tại
        $now = now();

        $topdeals = SanPhamModel::where('trangthai', 'Công khai')
            ->whereHas('bienthe', function ($query) use ($now) { // Nhớ truyền biến $now vào
                $query->whereIn('id', function ($subQuery) use ($now) {
                    $subQuery->select('sanphamthamgia_quatang.id_bienthe')
                        ->from('sanphamthamgia_quatang')
                        ->join('quatang_sukien', 'sanphamthamgia_quatang.id_quatang', '=', 'quatang_sukien.id')

                        // 1. Check trạng thái hiển thị
                        ->where('quatang_sukien.trangthai', 'Hiển thị')

                        // 2. Check ngày bắt đầu: Phải diễn ra rồi (nhỏ hơn hoặc bằng giờ hiện tại)
                        ->where('quatang_sukien.ngaybatdau', '<=', $now)

                        // 3. Check ngày kết thúc: Chưa kết thúc (lớn hơn hoặc bằng giờ hiện tại)
                        ->where('quatang_sukien.ngayketthuc', '>=', $now);
                });
            })
            ->with(['hinhanhsanpham', 'thuonghieu', 'danhmuc', 'bienthe'])
            ->withSum('bienthe', 'luotban')
            ->orderBy('bienthe_sum_luotban', 'desc')
            ->limit(10)
            ->get()

            // --- GIỮ NGUYÊN PHẦN XỬ LÝ GIÁ BÊN DƯỚI ---
            ->tap(function ($collection) {
                $collection->each(function ($sanpham) {
                    if ($sanpham->bienthe->isNotEmpty()) {
                        $cheapestVariant = $sanpham->bienthe->sortBy('giagoc')->first();
                        $sanpham->bienthe = $cheapestVariant;
                        $giagoc = $cheapestVariant->giagoc;
                        $giamgiaPercent = $sanpham->giamgia / 100;
                        $sanpham->giadagiam = $giagoc * (1 - $giamgiaPercent);
                    } else {
                        $sanpham->bienthe = null;
                        $sanpham->giadagiam = null;
                    }
                });
            });

        return $topdeals;
    }
    protected function quatang()
    {
        QuatangsukienModel::where('trangthai', 'Hiển thị')
            ->whereDoesntHave('sanphamduoctang', function (Builder $query) {
                $query->where('luottang', '>', 0);
            })
            ->update(['trangthai' => 'Tạm ẩn']);

        $quatang = QuatangsukienModel::where('trangthai', 'Hiển thị')
            ->where('deleted_at', null)
            ->where('ngaybatdau', '<=', now())
            ->where('ngayketthuc', '>=', now())
            ->orderBy('luotxem', 'desc')
            ->limit(10)
            ->get();

        return $quatang;
    }
    protected function danhmuchangdau()
    {
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

        $topCategoriesList = DanhmucModel::whereIn('id', $topCategoryIds)
            ->get()
            ->sortBy(function ($category) use ($topCategorySales) {
                $salesData = $topCategorySales->firstWhere('id_danhmuc', $category->id);
                return $salesData ? $salesData->total_sales : 0;
            }, SORT_REGULAR, true);

        $topProductsByCategory = collect();

        foreach ($topCategoryIds as $categoryId) {
            $products = SanphamModel::with(['hinhanhsanpham', 'thuonghieu', 'danhmuc', 'bienthe'])
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
                ->tap(function ($collection) {
                    $collection->each(function ($sanpham) {
                        if ($sanpham->bienthe->isNotEmpty()) {
                            $cheapestVariant = $sanpham->bienthe->sortBy('giagoc')->first();
                            $sanpham->bienthe = $cheapestVariant;
                            $giagoc = $cheapestVariant->giagoc;
                            $giamgiaPercent = $sanpham->giamgia / 100;
                            $sanpham->giadagiam = $giagoc * (1 - $giamgiaPercent);
                        } else {
                            $sanpham->bienthe = null;
                            $sanpham->giadagiam = null;
                        }
                    });
                });

            $topProductsByCategory->put($categoryId, $products);
        }

        return [
            'danhsachdmhangdau' => $topCategoriesList,
            'sanphamthuocdanhmuc' => $topProductsByCategory,
        ];
    }
    protected function thuonghieuhangdau()
    {
        $topBrandSales = BientheModel::whereIn('bienthe.trangthai', ['Còn hàng', 'Sắp hết hàng'])
            ->whereNull('bienthe.deleted_at')
            ->join('sanpham', 'bienthe.id_sanpham', '=', 'sanpham.id')
            ->join('thuonghieu', 'sanpham.id_thuonghieu', '=', 'thuonghieu.id')
            ->select('thuonghieu.id')
            ->selectRaw('SUM(bienthe.luotban) as total_sales')
            ->groupBy('thuonghieu.id')
            ->orderByDesc('total_sales')
            ->limit(5)
            ->get();

        $topBrandIds = $topBrandSales->pluck('id')->toArray();

        $topBrands = ThuonghieuModel::whereIn('id', $topBrandIds)
            ->get()
            ->sortBy(function ($brand) use ($topBrandSales) {
                $salesData = $topBrandSales->firstWhere('id', $brand->id);
                return $salesData ? $salesData->total_sales : 0;
            }, SORT_REGULAR, true);

        return $topBrands;
    }
    protected function sanphamhangdau()
    {
        $topProducts = SanphamModel::where('trangthai', 'Công khai')
            ->with(['hinhanhsanpham', 'thuonghieu', 'danhmuc', 'bienthe'])
            ->withSum('bienthe', 'luotban')
            ->orderBy('bienthe_sum_luotban', 'desc')
            ->limit(10)
            ->get()
            ->tap(function ($collection) {
                $collection->each(function ($sanpham) {
                    if ($sanpham->bienthe->isNotEmpty()) {
                        $cheapestVariant = $sanpham->bienthe->sortBy('giagoc')->first();
                        $sanpham->bienthe = $cheapestVariant;
                        $giagoc = $cheapestVariant->giagoc;
                        $giamgiaPercent = $sanpham->giamgia / 100;
                        $sanpham->giadagiam = $giagoc * (1 - $giamgiaPercent);
                    } else {
                        $sanpham->bienthe = null;
                        $sanpham->giadagiam = null;
                    }
                });
            });
        return $topProducts;
    }
    protected function hangmoichaosan()
    {
        $newProducts = SanPhamModel::where('trangthai', 'Công khai')
            ->with(['hinhanhsanpham', 'thuonghieu', 'danhmuc', 'bienthe'])
            ->withSum('bienthe', 'luotban')
            ->orderBy('id', 'desc')
            ->limit(18)
            ->get()
            ->tap(function ($collection) {
                $collection->each(function ($sanpham) {
                    if ($sanpham->bienthe->isNotEmpty()) {
                        $cheapestVariant = $sanpham->bienthe->sortBy('giagoc')->first();
                        $sanpham->bienthe = $cheapestVariant;
                        $giagoc = $cheapestVariant->giagoc;
                        $giamgiaPercent = $sanpham->giamgia / 100;
                        $sanpham->giadagiam = $giagoc * (1 - $giamgiaPercent);
                    } else {
                        $sanpham->bienthe = null;
                        $sanpham->giadagiam = null;
                    }
                });
            });
        return $newProducts;
    }
    protected function cothebanyeuThich()
    {
        $likeProducts = SanPhamModel::where('trangthai', 'Công khai')
            ->with(['hinhanhsanpham', 'thuonghieu', 'danhmuc', 'bienthe'])
            ->withSum('bienthe', 'luotban')
            ->orderBy('luotxem', 'desc')
            ->limit(18)
            ->get()
            ->tap(function ($collection) {
                $collection->each(function ($sanpham) {
                    if ($sanpham->bienthe->isNotEmpty()) {
                        $cheapestVariant = $sanpham->bienthe->sortBy('giagoc')->first();
                        $sanpham->bienthe = $cheapestVariant;
                        $giagoc = $cheapestVariant->giagoc;
                        $giamgiaPercent = $sanpham->giamgia / 100;
                        $sanpham->giadagiam = $giagoc * (1 - $giamgiaPercent);
                    } else {
                        $sanpham->bienthe = null;
                        $sanpham->giadagiam = null;
                    }
                });
            });
        return $likeProducts;
    }
}
