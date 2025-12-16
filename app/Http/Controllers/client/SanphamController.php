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
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Collection;
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

    // ... (Các use khác của bạn)

    public function search(Request $request)
    {
        $keyword = trim($request->input('query'));

        // Lưu ý: keyword để tính toán similar_text không nên strtolower ngay ở đây
        // để giữ nguyên hoa thường nếu cần, nhưng similar_text nên so sánh cùng loại.
        // Ta sẽ strtolower khi so sánh.
        $keywordClean = strtolower($keyword);

        // 1. Xử lý lưu lịch sử từ khóa (Giữ nguyên)
        if (!empty($keywordClean)) {
            $tukhoa = TukhoaModel::where('tukhoa', $keywordClean)->first();
            if ($tukhoa) {
                $tukhoa->increment('luottruycap');
            } else {
                TukhoaModel::create(['tukhoa' => $keywordClean, 'luottruycap' => 1]);
            }
        }

        // 2. Khởi tạo Query cơ bản
        $query = SanPhamModel::where('trangthai', 'Công khai')
            ->with(['hinhanhsanpham', 'thuonghieu', 'danhmuc', 'bienthe'])
            ->withSum('bienthe', 'luotban')
            ->orderBy('id', 'desc');

        // 3. Kiểm tra xem từ khóa có phải tên Danh Mục không?
        $danhmuc = DanhmucModel::whereRaw('LOWER(ten) = ?', [$keywordClean])->first();

        // =================================================================================
        // TRƯỜNG HỢP 1: TÌM THEO DANH MỤC (Giữ nguyên logic cũ cho nhanh)
        // =================================================================================
        if ($danhmuc) {
            $query->whereHas('danhmuc', function ($q) use ($danhmuc) {
                $q->where('id_danhmuc', $danhmuc->id);
            });

            // Phân trang Database thuần túy
            $products = $query->paginate(20)->through(function ($sanpham) {
                return $this->calcPriceInfo($sanpham); // Gọi hàm phụ tách ra cho gọn
            });

            $results_count = $products->total();
        }
        // =================================================================================
        // TRƯỜNG HỢP 2: TÌM THEO TỪ KHÓA (Áp dụng Similar Text & Manual Pagination)
        // =================================================================================
        else {
            // A. Lọc thô từ Database (Lấy tất cả sản phẩm có chứa ít nhất 1 từ)
            if (!empty($keywordClean)) {
                $words = explode(' ', $keywordClean);
                $words = array_filter($words);

                $query->where(function ($q) use ($words) {
                    foreach ($words as $word) {
                        $q->orWhere('ten', 'like', '%' . $word . '%');
                    }
                });
            }

            // Lấy toàn bộ dữ liệu thô (Chưa phân trang)
            $candidates = $query->get();

            // B. Xử lý PHP: Tính toán giá & Chấm điểm độ giống nhau
            $processedProducts = $candidates->map(function ($sanpham) use ($keywordClean) {
                // 1. Tính toán giá (Biến thể, giảm giá...)
                $sanpham = $this->calcPriceInfo($sanpham);

                // 2. Tính điểm giống nhau (Relevance Score)
                $percent = 0;
                // So sánh tên sản phẩm với từ khóa tìm kiếm
                similar_text(strtolower($sanpham->ten), $keywordClean, $percent);
                $sanpham->relevance_score = $percent;

                return $sanpham;
            })
                // C. Lọc: Chỉ lấy sản phẩm giống trên 40% (Bạn có thể chỉnh số này)
                ->filter(function ($sanpham) {
                    return $sanpham->relevance_score >= 25;
                })
                // D. Sắp xếp: Sản phẩm giống nhất lên đầu
                ->sortByDesc('relevance_score')
                ->values(); // Reset lại key array

            // E. Phân trang thủ công (Manual Pagination) cho Collection
            $results_count = $processedProducts->count(); // Đếm số lượng sau khi lọc
            $perPage = 20;
            $currentPage = Paginator::resolveCurrentPage();

            // Cắt dữ liệu cho trang hiện tại
            $currentPageItems = $processedProducts->slice(($currentPage - 1) * $perPage, $perPage)->values();

            $products = new LengthAwarePaginator(
                $currentPageItems,
                $results_count,
                $perPage,
                $currentPage,
                ['path' => Paginator::resolveCurrentPath(), 'query' => $request->query()]
            );
        }

        // 4. Lấy dữ liệu sidebar (Giữ nguyên)
        $danhsachdanhmuc = DanhmucModel::where('trangthai', 'Hiển thị')->withCount('sanpham')->get();
        $danhsachthuonghieu = ThuonghieuModel::where('trangthai', 'Hoạt động')->withCount('sanpham')->get();
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

    /**
     * Hàm phụ: Tính toán thông tin giá và biến thể
     * Tách ra để dùng chung cho cả 2 trường hợp
     */
    private function calcPriceInfo($sanpham)
    {
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
