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
    // Hàm index: Danh sách sản phẩm + Lọc + Sắp xếp
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

        // Lưu lịch sử từ khóa
        if (!empty($keywordClean)) {
            TukhoaModel::updateOrCreate(
                ['tukhoa' => $keywordClean],
                ['luottruycap' => DB::raw('luottruycap + 1')]
            );
        }

        $query = SanphamModel::where('trangthai', 'Công khai')
            ->where('ten', 'like', '%' . $keywordClean . '%')
            ->with(['hinhanhsanpham', 'bienthe', 'thuonghieu'])
            ->withSum('bienthe', 'luotban')
            ->paginate(20);

        return response()->json([
            'status' => 'success',
            'keyword' => $keyword,
            'data' => SanphamResource::collection($query)->response()->getData(true)
        ]);
    }
}