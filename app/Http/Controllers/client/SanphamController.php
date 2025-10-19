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
use Illuminate\Support\Facades\DB;

class SanphamController extends Controller
{
    public function index(Request $request){

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

            $query = SanPhamModel::where('trangthai', 'Công khai')
                ->where('ten', 'like', '%' . $keyword . '%')
                ->with(['hinhanhsanpham', 'thuonghieu', 'danhmuc', 'bienthe'])
                ->withSum('bienthe', 'luotban');
            
            // Lấy tổng số kết quả trước khi phân trang (cho $results_count)
            $totalResults = $query->count();
            $results_count = $totalResults;
            
            $products = $query->paginate(12)
                ->through(function ($sanpham) {
                    // Logic tính toán giá, được áp dụng sau khi phân trang.
                    if ($sanpham->bienthe->isNotEmpty()) {
                        $cheapestVariant = $sanpham->bienthe->sortBy('giagoc')->first();
                        $sanpham->bienthe = $cheapestVariant; 
                        $giagoc = $cheapestVariant->giagoc;
                        $giamgiaPercent = $sanpham->giamgia / 100;
                        $sanpham->giadagiam = intval($giagoc * (1 - $giamgiaPercent)); 
                        
                        // Thêm is_sale để dễ kiểm tra trong blade
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
}
