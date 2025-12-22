<?php

namespace App\Http\Controllers\client\api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\SanphamModel;
use App\Models\ThuonghieuModel;
use App\Models\DanhmucModel;
use App\Models\TukhoaModel;
use App\Models\QuangcaoModel;
use App\Http\Resources\SanphamResource;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\DB;

class SanphamController extends Controller
{
    /**
     * @OA\Get(
     * path="/api/v1/san-pham",
     * tags={"Sản phẩm"},
     * summary="Danh sách sản phẩm mới nhất (có áp dụng bộ lọc và sắp xếp)",
     * @OA\Response(response=200, description="Thành công")
     * )
     * 
     * @SWG\Response(response=200, description="successful operation"),
     */
    public function index(Request $request)
    {
        $filterdanhmuc = $request->input('danhmuc');
        $filterthuonghieu = $request->input('thuonghieu');
        $filtergia = $request->input('locgia');
        $sortby = $request->input('sortby', 'latest');

        $query = SanphamModel::where('trangthai', 'Công khai')
            ->with(['hinhanhsanpham', 'thuonghieu', 'danhmuc', 'bienthe'])
            ->withSum('bienthe', 'luotban');

        // Lọc theo danh mục (slug)
        if (!empty($filterdanhmuc)) {
            $query->whereHas('danhmuc', function ($q) use ($filterdanhmuc) {
                $q->where('slug', $filterdanhmuc);
            });
        }

        // Lọc theo thương hiệu (slug)
        if (!empty($filterthuonghieu)) {
            $query->whereHas('thuonghieu', function ($q) use ($filterthuonghieu) {
                $q->where('slug', $filterthuonghieu);
            });
        }

        // Lọc giá
        if ($filtergia) {
            $rangeMap = [
                'low100' => [0, 100000],
                'to200' => [100000, 200000],
                'to300' => [200000, 300000],
                'to500' => [300000, 500000],
                'to700' => [500000, 700000],
                'to1000' => [700000, 1000000],
                'high1000' => [1000000, 999999999],
            ];
            if (isset($rangeMap[$filtergia])) {
                $query->whereHas('bienthe', function ($q) use ($rangeMap, $filtergia) {
                    $q->whereBetween('giagoc', $rangeMap[$filtergia]);
                });
            }
        }

        // Sắp xếp
        switch ($sortby) {
            case 'sanphamhangdau':
                $query->orderByDesc('bienthe_sum_luotban');
                break;
            case 'topdeals':
                $query->where('giamgia', '>', 0)->orderByDesc('bienthe_sum_luotban');
                break;
            case 'gia_asc':
            case 'gia_desc':
                $direction = ($sortby == 'gia_asc') ? 'asc' : 'desc';
                $query->join('bienthe', 'sanpham.id', '=', 'bienthe.id_sanpham')
                    ->select('sanpham.*', DB::raw('MIN(bienthe.giagoc) as min_price'))
                    ->groupBy('sanpham.id')
                    ->orderBy('min_price', $direction);
                break;
            case 'quantamnhieunhat':
                $query->orderByDesc('luotxem');
                break;
            case 'latest':
            default:
                $query->orderByDesc('id');
                break;
        }

        $products = $query->paginate(20);

        return response()->json([
            'status' => 'success',
            'data' => SanphamResource::collection($products)->response()->getData(true),
            'filters' => [
                'categories' => DanhmucModel::where('trangthai', 'Hiển thị')->get(['id', 'ten', 'slug']),
                'brands' => ThuonghieuModel::where('trangthai', 'Hoạt động')->get(['id', 'ten', 'slug']),
                'banners' => QuangcaoModel::where('trangthai', 'Hiển thị')->where('vitri', 'home_banner_product')->get()
            ]
        ]);
    }

    // Hàm chi tiết sản phẩm
    public function show($slug)
    {
        $sanpham = SanphamModel::where('slug', $slug)
            ->where('trangthai', 'Công khai')
            ->with(['danhmuc', 'hinhanhsanpham', 'bienthe', 'thuonghieu'])
            ->first();

        if (!$sanpham) {
            return response()->json(['status' => 'error', 'message' => 'Sản phẩm không tồn tại'], 404);
        }

        $sanpham->increment('luotxem');

        // Sản phẩm liên quan
        $relatedProducts = SanphamModel::where('trangthai', 'Công khai')
            ->where('id', '!=', $sanpham->id)
            ->whereHas('danhmuc', function ($q) use ($sanpham) {
                $q->whereIn('id_danhmuc', $sanpham->danhmuc->pluck('id'));
            })
            ->with(['hinhanhsanpham', 'bienthe'])
            ->limit(10)->get();

        return response()->json([
            'status' => 'success',
            'data' => new SanphamResource($sanpham),
            'related' => SanphamResource::collection($relatedProducts)
        ]);
    }

    // Hàm tìm kiếm (Search)
    public function search(Request $request)
    {
        $keyword = trim($request->input('query'));
        $keywordClean = strtolower($keyword);

        // 1. Xử lý lưu lịch sử từ khóa (Giữ nguyên 100%)
        if (!empty($keywordClean)) {
            $tukhoa = \App\Models\TukhoaModel::where('tukhoa', $keywordClean)->first();
            if ($tukhoa) {
                $tukhoa->increment('luottruycap');
            } else {
                \App\Models\TukhoaModel::create(['tukhoa' => $keywordClean, 'luottruycap' => 1]);
            }
        }

        // 2. Khởi tạo Query cơ bản
        $query = \App\Models\SanphamModel::where('trangthai', 'Công khai')
            ->with(['hinhanhsanpham', 'thuonghieu', 'danhmuc', 'bienthe'])
            ->withSum('bienthe', 'luotban')
            ->orderBy('id', 'desc');

        // 3. Kiểm tra xem từ khóa có phải tên Danh Mục không?
        $danhmuc = \App\Models\DanhmucModel::whereRaw('LOWER(ten) = ?', [$keywordClean])->first();

        // =================================================================================
        // TRƯỜNG HỢP 1: TÌM THEO DANH MỤC
        // =================================================================================
        if ($danhmuc) {
            $query->whereHas('danhmuc', function ($q) use ($danhmuc) {
                $q->where('id_danhmuc', $danhmuc->id);
            });

            $productsPaginated = $query->paginate(20)->through(function ($sanpham) {
                return $this->calcPriceInfo($sanpham); // Sử dụng hàm phụ bạn đã viết
            });

            $results_count = $productsPaginated->total();
            // Chuyển kết quả sang Resource để lấy link ảnh Full
            $productsData = \App\Http\Resources\SanphamResource::collection($productsPaginated)->response()->getData(true);
        }
        // =================================================================================
        // TRƯỜNG HỢP 2: TÌM THEO TỪ KHÓA (Similar Text & Manual Pagination)
        // =================================================================================
        else {
            if (!empty($keywordClean)) {
                $words = explode(' ', $keywordClean);
                $words = array_filter($words);

                $query->where(function ($q) use ($words) {
                    foreach ($words as $word) {
                        // Trong SQL của bạn là 'ten'
                        $q->orWhere('ten', 'like', '%' . $word . '%');
                    }
                });
            }

            $candidates = $query->get();

            $processedProducts = $candidates->map(function ($sanpham) use ($keywordClean) {
                // 1. Tính toán giá (Biến thể, giảm giá...) - Giữ nguyên logic cũ
                $sanpham = $this->calcPriceInfo($sanpham);

                // 2. Tính điểm giống nhau (Relevance Score)
                $percent = 0;
                similar_text(strtolower($sanpham->ten), $keywordClean, $percent);
                $sanpham->relevance_score = $percent;

                return $sanpham;
            })
                ->filter(function ($sanpham) {
                    return $sanpham->relevance_score >= 25;
                })
                ->sortByDesc('relevance_score')
                ->values();

            $results_count = $processedProducts->count();
            $perPage = 20;
            $currentPage = \Illuminate\Pagination\Paginator::resolveCurrentPage() ?: 1;

            $currentPageItems = $processedProducts->slice(($currentPage - 1) * $perPage, $perPage)->values();

            $productsPaginated = new \Illuminate\Pagination\LengthAwarePaginator(
                $currentPageItems,
                $results_count,
                $perPage,
                $currentPage,
                ['path' => \Illuminate\Pagination\Paginator::resolveCurrentPath(), 'query' => $request->query()]
            );

            $productsData = \App\Http\Resources\SanphamResource::collection($productsPaginated)->response()->getData(true);
        }

        // 4. Lấy dữ liệu sidebar (Nối Full URL cho ảnh ở đây luôn)
        $danhsachdanhmuc = \App\Models\DanhmucModel::where('trangthai', 'Hiển thị')->withCount('sanpham')->get()
            ->map(function ($item) {
                $item->hinhanh = $item->hinhanh ? asset('assets/client/images/categories/' . $item->hinhanh) : null;
                return $item;
            });

        $danhsachthuonghieu = \App\Models\ThuonghieuModel::where('trangthai', 'Hoạt động')->withCount('sanpham')->get()
            ->map(function ($item) {
                $item->hinhanh = $item->hinhanh ? asset('assets/client/images/brands/' . $item->hinhanh) : null;
                return $item;
            });

        $bannerquangcao = \App\Models\QuangcaoModel::where('trangthai', 'Hiển thị')->where('vitri', 'home_banner_product')->get()
            ->map(function ($item) {
                $item->hinhanh = asset('assets/client/images/bg/' . $item->hinhanh);
                return $item;
            });

        // Trả về JSON đầy đủ các biến như bản View
        return response()->json([
            'status' => 200,
            'keyword' => $keyword,
            'results_count' => $results_count,
            'products' => $productsData,
            'sidebar' => [
                'danhsachdanhmuc' => $danhsachdanhmuc,
                'danhsachthuonghieu' => $danhsachthuonghieu,
                'bannerquangcao' => $bannerquangcao,
            ]
        ]);
    }

    // Hàm phụ tính giá và giảm giá cho sản phẩm
    private function calcPriceInfo($sanpham)
    {
        if ($sanpham->bienthe->isNotEmpty()) {
            $cheapestVariant = $sanpham->bienthe->sortBy('giagoc')->first();
            // Gán ngược lại để dùng ở Resource
            $sanpham->bienthe_selected = $cheapestVariant;
            $giagoc = $cheapestVariant->giagoc;
            $giamgiaPercent = $sanpham->giamgia / 100;

            $sanpham->giadagiam = intval($giagoc * (1 - $giamgiaPercent));
            $sanpham->is_sale = intval($sanpham->giadagiam) < intval($giagoc);
        } else {
            $sanpham->bienthe_selected = null;
            $sanpham->giadagiam = null;
            $sanpham->is_sale = false;
        }
        return $sanpham;
    }
}