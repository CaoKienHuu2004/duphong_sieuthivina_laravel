<?php

namespace App\Http\Controllers\client;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\SanphamModel;
use App\Models\ThuonghieuModel;
use App\Models\DanhmucModel;
use App\Models\TukhoaModel;
use App\Models\QuangcaoModel;
use App\Models\BientheModel;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\DB;

class SanphamController extends Controller
{
    public function index(Request $request)
    {

        $title = 'Danh sách sản phẩm';
        $filterdanhmuc = $request->input('danhmuc');
        $filterthuonghieu = $request->input('thuonghieu');
        $filtergia = $request->input('locgia');
        $sortby = $request->input('sortby', 'latest');

        $query = SanPhamModel::where('trangthai', 'Công khai')
            ->with(['hinhanhsanpham', 'thuonghieu', 'danhmuc', 'bienthe'])
            ->withSum('bienthe', 'luotban');

        if (!empty($filterdanhmuc)) {
            $danhmuc = DanhmucModel::where('slug', $filterdanhmuc)->first();
            if ($danhmuc) {
                $id_danhmuc = $danhmuc->id;
                $query->whereHas('danhmuc', function ($q) use ($id_danhmuc) {
                    $q->where('id_danhmuc', $id_danhmuc);
                });

                if (!$filterthuonghieu) {
                    $title = 'Danh mục: ' . $danhmuc->ten;
                }
            }
        }

        if (!empty($filterthuonghieu)) {
            $thuonghieu = ThuonghieuModel::where('slug', $filterthuonghieu)->first();
            if ($thuonghieu) {
                $id_thuonghieu = $thuonghieu->id;
                $query->where('id_thuonghieu', $id_thuonghieu);
                if (!$filterdanhmuc) {
                    $title = 'Thương hiệu: ' . $thuonghieu->ten;
                }
            }
        }

        if ($filtergia) {
            $price_min = null;
            $price_max = null;
            $rangeMap = [
                'low100' => [0, 100000],
                'to200' => [100000, 200000],
                'to300' => [200000, 300000],
                'to500' => [300000, 500000],
                'to700' => [500000, 700000],
                'to1000' => [700000, 1000000],
                'high1000' => [1000000, null],
            ];

            if (isset($rangeMap[$filtergia])) {
                list($price_min, $price_max) = $rangeMap[$filtergia];
            }

            if ($price_min !== null || $price_max !== null) {
                $query->whereHas('bienthe', function ($q) use ($price_min, $price_max) {
                    $q->select('id_sanpham')
                        ->groupBy('id_sanpham');

                    if ($price_min !== null) {
                        $q->havingRaw('MIN(giagoc) >= ?', [$price_min]);
                    }
                    if ($price_max !== null) {
                        $q->havingRaw('MIN(giagoc) <= ?', [$price_max]);
                    }
                });
            }
        }

        // --- BỔ SUNG LOGIC PHÂN TÍCH SORTBY CHO DANH MỤC HÀNG ĐẦU ---
        $categorySlugForSort = null;
        $isCategorySort = str_starts_with($sortby, 'top-');

        if ($isCategorySort) {
            $parts = explode('-', $sortby, 2);
            if (count($parts) === 2) {
                $categorySlugForSort = $parts[1];
                // Thiết lập $sortby thành key chung để khớp với switch-case
                $sortby = 'danhmuchangdau';
            }
        }
        // --- END BỔ SUNG LOGIC ---

        // 6. SẮP XẾP (sortby)
        switch ($sortby) {
            case 'sanphamhangdau':
                $query->orderByDesc('bienthe_sum_luotban');
                $title = 'Sản phẩm hàng đầu';
                break;

            case 'topdeals':
                $query->where('giamgia', '>', 0)
                    ->orderByDesc('bienthe_sum_luotban');
                $title = 'TOP DEAL - SIÊU RẺ';
                break;

            case 'danhmuchangdau':
                if ($categorySlugForSort) {
                    $danhmucSort = DanhmucModel::where('slug', $categorySlugForSort)->first();
                    if ($danhmucSort) {
                        $topCatId = $danhmucSort->id;
                        $query->whereHas('danhmuc', function (Builder $q) use ($topCatId) {
                            $q->where('id_danhmuc', $topCatId);
                        });
                        $title = 'Danh mục hàng đầu: ' . $danhmucSort->ten;
                    }
                }
                // Sau đó sắp xếp theo lượt bán (Áp dụng withSum trên SanPhamModel là đúng)
                $query->orderByDesc('bienthe_sum_luotban');
                break;

            case 'gia_asc':
                $query->leftJoin('bienthe AS cheapest_variant', function ($join) {
                    $join->on('cheapest_variant.id_sanpham', '=', 'sanpham.id')
                        ->whereRaw('cheapest_variant.giagoc = (SELECT MIN(giagoc) FROM bienthe WHERE id_sanpham = sanpham.id)');
                })
                    ->orderBy('cheapest_variant.giagoc', 'asc')
                    ->select('sanpham.*');
                break;

            case 'gia_desc':
                $query->leftJoin('bienthe AS cheapest_variant', function ($join) {
                    $join->on('cheapest_variant.id_sanpham', '=', 'sanpham.id')
                        ->whereRaw('cheapest_variant.giagoc = (SELECT MIN(giagoc) FROM bienthe WHERE id_sanpham = sanpham.id)');
                })
                    ->orderBy('cheapest_variant.giagoc', 'desc')
                    ->select('sanpham.*');
                break;

            case 'quantamnhieunhat':
                $query->orderByDesc('luotxem');
                $title = 'ĐƯỢC QUAN TÂM NHIỀU NHẤT';
                break;

            case 'latest':
            default:
                $query->orderByDesc('sanpham.id');
                break;
        }

        $products = $query->paginate(20)
            ->through(function ($sanpham) {
                if ($sanpham->bienthe->isNotEmpty()) {
                    $cheapestVariant = $sanpham->bienthe->sortBy('giagoc')->first();
                    $sanpham->bienthe = $cheapestVariant;
                    $giagoc = $cheapestVariant->giagoc;
                    $giamgiaPercent = $sanpham->giamgia / 100;
                    $sanpham->giadagiam = intval($giagoc * (1 - $giamgiaPercent));
                    $sanpham->is_sale = intval($sanpham->giadagiam) < intval($giagoc);
                } else {
                    $sanpham->bienthe = null;
                    $sanpham->giadagiam = null;
                    $sanpham->is_sale = false;
                }
                return $sanpham;
            })->withQueryString();

        $danhsachdanhmuc = DanhmucModel::where('trangthai', 'Hiển thị')
            ->withCount('sanpham')
            ->get();
        $danhsachthuonghieu = ThuonghieuModel::where('trangthai', 'Hoạt động')
            ->withCount('sanpham')
            ->get();
        $bannerquangcao = QuangcaoModel::where('trangthai', 'Hiển thị')->where('vitri', 'home_banner_product')->get();

        return view('client.sanpham.index', [
            'products' => $products,
            'title' => $title,
            'danhsachdanhmuc' => $danhsachdanhmuc,
            'danhsachthuonghieu' => $danhsachthuonghieu,
            'bannerquangcao' => $bannerquangcao,
            'input' => $request->all(),
        ]);
    }

    public function search(Request $request)
    {

        $keyword = trim($request->input('query'));
        $keyword = strtolower($keyword);

        $products = new LengthAwarePaginator([], 0, 12, 1); // Khởi tạo Paginator RỖNG mặc định
        $results_count = 0; // Khởi tạo results_count mặc định

        if (!empty($keyword)) {
            $tukhoa = TukhoaModel::where('tukhoa', $keyword)->first();
            if ($tukhoa) {
                $tukhoa->increment('luottruycap');
            } else {
                TukhoaModel::create([
                    'tukhoa' => $keyword,
                    'luottruycap' => 1,
                ]);
            }

            $danhmuc = DanhmucModel::whereRaw('LOWER(ten) = ?', [$keyword])->first();

            $query = SanPhamModel::where('trangthai', 'Công khai')
                ->with(['hinhanhsanpham', 'thuonghieu', 'danhmuc', 'bienthe'])
                ->withSum('bienthe', 'luotban')
                ->orderBy('id', 'desc');

            if ($danhmuc) {
                $query->whereHas('danhmuc', function ($q) use ($danhmuc) {
                    $q->where('id_danhmuc', $danhmuc->id);
                });
            } else {
                $words = explode(' ', $keyword);
                $words = array_filter($words); 

                $query->where(function ($q) use ($words) {
                    foreach ($words as $word) {
                        $q->orWhere('ten', 'like', '%' . $word . '%');
                    }
                });
            }

            $totalResults = $query->count();
            $results_count = $totalResults;

            $products = $query->paginate(20)
                ->through(function ($sanpham) {
                    if ($sanpham->bienthe->isNotEmpty()) {
                        $cheapestVariant = $sanpham->bienthe->sortBy('giagoc')->first();
                        $sanpham->bienthe = $cheapestVariant;
                        $giagoc = $cheapestVariant->giagoc;
                        $giamgiaPercent = $sanpham->giamgia / 100;
                        $sanpham->giadagiam = intval($giagoc * (1 - $giamgiaPercent));
                        $sanpham->is_sale = intval($sanpham->giadagiam) < intval($giagoc);
                    } else {
                        $sanpham->bienthe = null;
                        $sanpham->giadagiam = null;
                        $sanpham->is_sale = false;
                    }
                    return $sanpham;
                });
        }

        $danhsachdanhmuc = DanhmucModel::where('trangthai', 'Hiển thị')
            ->withCount('sanpham')
            ->get();
        $danhsachthuonghieu = ThuonghieuModel::where('trangthai', 'Hoạt động')
            ->withCount('sanpham')
            ->get();
        $bannerquangcao = QuangcaoModel::where('trangthai', 'Hiển thị')->where('vitri', 'home_banner_product')->get();

        return view('client.sanpham.search', [
            'keyword' => $keyword,
            'products' => $products,
            'results_count' => $results_count,
            'danhsachdanhmuc' => $danhsachdanhmuc,
            'danhsachthuonghieu' => $danhsachthuonghieu,
            'bannerquangcao' => $bannerquangcao,
        ]);
    }

    public function show($slug)
    {
        $sanpham = SanPhamModel::where('slug', $slug)
            ->where('trangthai', 'Công khai')
            ->with([
                'danhmuc',
                'hinhanhsanpham',
                'bienthe',
                'thuonghieu'
            ])
            ->firstOrFail();

        $sanpham->bienthe->each(function ($bienthe) use ($sanpham) {
            $giagoc = $bienthe->giagoc;
            $giamgiaPercent = $sanpham->giamgia / 100;
            $bienthe->giadagiam = intval($giagoc * (1 - $giamgiaPercent));
            $bienthe->is_sale = intval($bienthe->giadagiam) < intval($giagoc);
        });

        $sanpham->increment('luotxem');

        $relatedProducts = $this->fetchRelatedProducts($sanpham);


        // return response()->json([
        //     'sanpham' => $sanpham,
        //     'relatedProducts' => $relatedProducts,
        // ]);

        return view('client.sanpham.chitiet', [
            'sanpham' => $sanpham,
            'relatedProducts' => $relatedProducts,
        ]);
    }
    protected function fetchRelatedProducts($sanpham)
    {

        // Nếu sản phẩm không có danh mục nào được gán, trả về collection rỗng
        if ($sanpham->danhmuc->pluck('id')->isEmpty()) {
            return collect([]);
        }

        $relatedProducts = SanPhamModel::where('trangthai', 'Công khai')
            ->where('id', '!=', $sanpham->id)
            ->whereHas('danhmuc', function ($q) use ($sanpham) {
                // Lấy các sản phẩm có ít nhất một danh mục chung
                $q->whereIn('id_danhmuc', $sanpham->danhmuc->pluck('id'));
            })
            ->with(['danhmuc', 'hinhanhsanpham', 'thuonghieu', 'bienthe'])
            ->withSum('bienthe', 'luotban')
            ->orderByDesc('bienthe_sum_luotban')
            ->limit(10)
            ->get()
            ->map(function ($relatedSanpham) {
                if ($relatedSanpham->bienthe->isNotEmpty()) {
                    // Xử lý: Lấy biến thể rẻ nhất, tính giá đã giảm và xác định cờ giảm giá
                    $cheapestVariant = $relatedSanpham->bienthe->sortBy('giagoc')->first();
                    $relatedSanpham->bienthe = $cheapestVariant;
                    $giagoc = $cheapestVariant->giagoc;
                    $giamgiaPercent = $relatedSanpham->giamgia / 100;

                    $relatedSanpham->giadagiam = intval($giagoc * (1 - $giamgiaPercent));
                    $relatedSanpham->is_sale = intval($relatedSanpham->giadagiam) < intval($giagoc);
                } else {
                    // Xử lý khi không có biến thể
                    $relatedSanpham->bienthe = null;
                    $relatedSanpham->giadagiam = null;
                    $relatedSanpham->is_sale = false;
                }
                return $relatedSanpham;
            });

        return $relatedProducts;
    }
}
