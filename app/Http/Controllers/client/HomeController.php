<?php

namespace App\Http\Controllers\client;

use App\Http\Controllers\Controller;
use App\Models\BientheModel;
use App\Models\SanphamModel;
use App\Models\HinhanhsanphamModel;
use App\Models\DanhgiaModel;
use App\Models\CuahangModel;
use Illuminate\Http\Request;
use App\Models\TukhoaModel;
use App\Models\DanhmucModel;
use App\Models\QuangcaoModel;
use App\Models\QuatangsukienModel;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class HomeController extends Controller
{
    const BANNER_POSITIONS = [
        'home_banner_slider',
        'home_banner_event_1',
        'home_banner_event_2',
        'home_banner_event_3',
        'home_banner_event_4',
        'home_banner_promotion_1',
        'home_banner_promotion_2',
        'home_banner_promotion_3',
        'home_banner_ads',
        'home_banner_product',
    ];
    protected function vitriBanner(string $position, int $limit = null)
    {
        $statusActive = 'Hiển thị'; 

        $query = QuangcaoModel::where('vitri', $position)
                              ->where('trangthai', $statusActive)
                              ->orderBy('updated_at', 'desc');

        if ($limit === 1) {
            return $query->first();
        } elseif ($limit > 1) {
            return $query->take($limit)->get();
        }
        
        return $query->get();
    }
    public function index()
    {
        //============================================================
        // KHAI BÁO BANNER
        //============================================================
        $banners = [];
        
        $banners['home_banner_slider'] = $this->vitriBanner(self::BANNER_POSITIONS[0], 5);
        $banners['home_banner_event_1'] = $this->vitriBanner(self::BANNER_POSITIONS[1], 1);
        $banners['home_banner_event_2'] = $this->vitriBanner(self::BANNER_POSITIONS[2], 1); 
        $banners['home_banner_event_3'] = $this->vitriBanner(self::BANNER_POSITIONS[3], 1);
        $banners['home_banner_event_4'] = $this->vitriBanner(self::BANNER_POSITIONS[4], 1);
        $banners['home_banner_promotion_1'] = $this->vitriBanner(self::BANNER_POSITIONS[5], 1);
        $banners['home_banner_promotion_2'] = $this->vitriBanner(self::BANNER_POSITIONS[6], 1);
        $banners['home_banner_promotion_3'] = $this->vitriBanner(self::BANNER_POSITIONS[7], 1);
        $banners['home_banner_ads'] = $this->vitriBanner(self::BANNER_POSITIONS[8], 1);
        $banners['home_banner_product'] = $this->vitriBanner(self::BANNER_POSITIONS[9], 1);


        //============================================================
        // SHOW TẤT CẢ DANH MỤC
        //============================================================
            $danhsachdanhmuc = DanhmucModel::select('ten', 'logo', 'slug')->get();

        //============================================================
        // SHOW SẢN PHẨM TOPDEALS
        //============================================================
            $minPriceVariantSubquery = BientheModel::query()
                ->select('id_sanpham', 'giagoc')
                ->where('soluong', '>', 0)
                ->whereIn('trangthai', ['Còn hàng', 'Sắp hết hàng'])
                ->whereNull('deleted_at')
                ->orderBy('giagoc')
                ->distinct('id_sanpham'); 

            $topDeals = SanphamModel::query()
                ->with(['hinhanhsanpham', 'thuonghieu']) 
                ->select(
                    'sanpham.*',  
                    'min_variant.giagoc AS giagoc',

                    DB::raw('ROUND(min_variant.giagoc * (1 - sanpham.giamgia / 100)) AS gia_dagiam') 
                )
                ->where('sanpham.trangthai', 'Công khai')
                ->where('sanpham.giamgia', '>', 0) 
                ->leftJoinSub($minPriceVariantSubquery, 'min_variant', function ($join) {
                    $join->on('sanpham.id', '=', 'min_variant.id_sanpham');
                })
                ->orderByDesc('sanpham.giamgia') 
                ->orderByDesc('sanpham.luotban') 
                ->limit(10)
                ->get();

                // return response()->json([
                //     'success' => true,
                //     'data' => $topDeals
                // ]);

        //============================================================
        // HIỂN THỊ QUÀ TẶNG SỰ KIỆN
        //============================================================
            $today = Carbon::now();
            $quatangphobien = QuatangsukienModel::where('ngaybatdau', '<=', $today)
                                                ->where('ngayketthuc', '>=', $today)
                                                ->orderBy('luotxem','desc')
                                                ->limit(8)
                                                ->get();

           

        //============================================================
        // TRUYỀN DATA VÀO TRANG CHỦ
        //============================================================
        $data = array_merge($banners, compact('danhsachdanhmuc','topDeals', 'quatangphobien'));
        return view('client.index', $data); 
    }

    

    public function search(Request $request)
    {  
        $query = $request->input('query');
        $query = trim($query);

            if (empty($query)) {
                return redirect()->route('danh-sach-san-pham')->with('error', 'Vui lòng nhập từ khóa tìm kiếm.');
            }

            $searchTerm = '%' . $query . '%';

            $sanpham = SanphamModel::where('ten', 'like', $searchTerm)
                                    ->whereNull('deleted_at') 
                                    ->paginate(12);

            $this->capnhattukhoa($query);
            
            return view('client.sanpham.search', [
                'sanpham' => $sanpham,
                'search_query' => $query,
                'results_count' => $sanpham->total(),
                'title' => 'Kết quả tìm kiếm cho: "' . $query . '"'
            ]);
    } 
    
    protected function capnhattukhoa(string $keyword): void
    {
        TukhoaModel::updateOrCreate(
            ['tukhoa' => $keyword],
            ['luottruycap' => DB::raw('luottruycap + 1')]
        );
    }
}
