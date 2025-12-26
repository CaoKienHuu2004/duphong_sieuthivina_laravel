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
        $topdeals = SanPhamModel::where('trangthai', 'Công khai')
            // --- CẬP NHẬT ĐIỀU KIỆN LỌC ---
            ->whereHas('bienthe', function ($query) {
                // Chỉ lấy biến thể có ID nằm trong bảng tham gia quà tặng
                // VÀ chương trình quà tặng đó phải đang "Hiển thị"
                $query->whereIn('id', function ($subQuery) {
                    $subQuery->select('sanphamthamgia_quatang.id_bienthe')
                        ->from('sanphamthamgia_quatang')
                        // Join sang bảng quatang để check trạng thái
                        ->join('quatang_sukien', 'sanphamthamgia_quatang.id_quatang', '=', 'quatang_sukien.id')
                        ->where('quatang_sukien.trangthai', 'Hiển thị');
                });
            })
            // --------------------------------
            ->with(['hinhanhsanpham', 'thuonghieu', 'danhmuc', 'bienthe'])
            ->withSum('bienthe', 'luotban')
            ->orderBy('bienthe_sum_luotban', 'desc')
            ->limit(10)
            ->get()

            // --- XỬ LÝ GIÁ HIỂN THỊ (GIỮ NGUYÊN) ---
            ->tap(function ($collection) {
                $collection->each(function ($sanpham) {
                    if ($sanpham->bienthe->isNotEmpty()) {
                        // Lấy biến thể giá thấp nhất
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
        $topProducts = SanPhamModel::where('trangthai', 'Công khai')
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
