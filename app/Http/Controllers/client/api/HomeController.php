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
    protected function danhmuchangdau() {
        $topCatIds = BientheModel::join('sanpham', 'bienthe.id_sanpham', '=', 'sanpham.id')
            ->join('danhmuc_sanpham', 'sanpham.id', '=', 'danhmuc_sanpham.id_sanpham')
            ->select('danhmuc_sanpham.id_danhmuc')
            ->selectRaw('SUM(bienthe.luotban) as total')
            ->groupBy('danhmuc_sanpham.id_danhmuc')
            ->orderByDesc('total')->limit(5)->pluck('id_danhmuc');

        $categories = DanhmucModel::whereIn('id', $topCatIds)->get();
        
        $result = $categories->map(function($cat) {
            $prods = SanphamModel::whereHas('danhmuc', fn($q) => $q->where('id_danhmuc', $cat->id))
                ->with(['bienthe'])->withSum('bienthe', 'luotban')
                ->limit(12)->get();
            return [
                'category' => $cat,
                'products' => SanphamResource::collection($prods)
            ];
        });
        return $result;
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