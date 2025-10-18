<?php

namespace App\Http\Controllers\client;

use App\Http\Controllers\Controller;
use App\Models\DanhmucModel;
use App\Models\QuangcaoModel;
use App\Models\QuatangsukienModel;
use App\Models\SanPhamModel;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        $banner = $this->banner();
        $alldanhmuc = $this->alldanhmuc();
        $topdeals = $this->topdeals();
        $quatang = $this->quatang();

        // return response()->json([
        //     'banner' => $banner,
        //     'alldanhmuc' => $alldanhmuc,
        //     'topdeals' => $topdeals,
        // ]);
        return view('client.index', compact('banner', 'alldanhmuc', 'topdeals', 'quatang')); 
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
       $alldanhmuc = DanhmucModel::where('trangthai', 'Hiển thị')->get();
       return $alldanhmuc;
    }

    protected function topdeals()
    {
        $topdeals = SanPhamModel::where('giamgia', '>', 0) // Chỉ lấy sản phẩm có giảm giá
            ->where('trangthai', 'Công khai')
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

        return $topdeals;
    }
    protected function quatang()
    {
        $quatang = QuatangsukienModel::where('trangthai', 'Hiển thị')
                                ->where('deleted_at', null)
                                ->where('ngaybatdau', '<=', now())
                                ->where('ngayketthuc', '>=', now())
                                ->orderBy('luotxem', 'desc')
                                ->get();
        return $quatang;
    }
}
