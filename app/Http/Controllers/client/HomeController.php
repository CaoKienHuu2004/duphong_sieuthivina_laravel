<?php

namespace App\Http\Controllers\client;

use App\Http\Controllers\Controller;
use App\Models\SanphamModel;
use Illuminate\Http\Request;
use App\Models\TukhoaModel;
use App\Models\DanhmucModel;
use Illuminate\Support\Facades\DB;

class HomeController extends Controller
{
    /**
     * Lấy tất cả dữ liệu chung cần thiết cho layout (Danh mục, Placeholder).
     *
     * @return array
     */
    protected function getCommonData(): array
    {
        // 1. Lấy danh sách Danh mục
        $danhmuc = DanhmucModel::select('ten', 'logo')->get();

        // 2. Lấy Từ khóa Placeholder ngẫu nhiên từ TOP 20
        $tukhoaplaceholder = null;
        $top20tukhoa = TukhoaModel::orderBy('luottruycap', 'desc')->take(20)->get();
        
        if ($top20tukhoa->isNotEmpty()) {
            $tukhoaplaceholder = $top20tukhoa->random()->tukhoa;
        }
        
        // ⬅️ THÊM LOGIC LẤY TỪ KHÓA PHỔ BIẾN VÀO ĐÂY
        $tukhoaphobien = TukhoaModel::select('tukhoa')->orderBy('luottruycap', 'desc')->take(5)->get();

        // ⬅️ TRẢ VỀ CẢ tukhoaphobien
        return compact('danhmuc', 'tukhoaplaceholder', 'tukhoaphobien'); 
    }

    public function index(Request $request)
    {
        // Lấy dữ liệu chung cần cho layout (danhmuc, tukhoaplaceholder)
        $commonData = $this->getCommonData();

        $query = $request->input('query');
        
        // 1. KIỂM TRA: Xử lý TÌM KIẾM
        if ($query) {
            
            $query = trim($query);

            if (empty($query)) {
                // Nếu từ khóa rỗng, chuyển hướng
                return redirect()->route('danh-sach-san-pham')->with('error', 'Vui lòng nhập từ khóa tìm kiếm.');
            }

            $searchTerm = '%' . $query . '%';
            
            // Truy vấn sản phẩm
            $products = SanphamModel::where('ten', 'like', $searchTerm)
                                    ->whereNull('deleted_at') 
                                    ->paginate(12);

            // Cập nhật thống kê tìm kiếm
            $this->capnhattukhoa($query);
            
            // Trả về view kết quả tìm kiếm (sử dụng array_merge để gộp dữ liệu chung)
            return view('client.sanpham.search', array_merge($commonData, [
                'products' => $products,
                'search_query' => $query,
                'results_count' => $products->total(),
                'title' => 'Kết quả tìm kiếm cho: "' . $query . '"'
            ]));

        } else {
            // 2. Xử lý TRANG CHỦ
            
            // Lấy dữ liệu riêng cho trang chủ (Top 5 từ khóa phổ biến)
            $tukhoaphobien = TukhoaModel::select('tukhoa')->orderBy('luottruycap', 'desc')->take(5)->get();
            
            // Trả về view trang chủ (sử dụng array_merge để gộp dữ liệu chung)
            return view('client.index', array_merge($commonData, compact('tukhoaphobien')));
        }
    } 

    /**
     * Cập nhật lượt truy cập trong TukhoaModel.
     */
    protected function capnhattukhoa(string $keyword): void
    {
        TukhoaModel::updateOrCreate(
            ['tukhoa' => $keyword],
            ['luottruycap' => DB::raw('luottruycap + 1')]
        );
    }
}
