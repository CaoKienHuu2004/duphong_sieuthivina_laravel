<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;
use App\Models\DanhmucModel;
use App\Models\DonhangModel;
use App\Models\TukhoaModel;
use App\Models\NguoidungModel;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Auth;
use App\Listeners\MergeCartOnLogin;
use App\Models\GiohangModel;
use Illuminate\Auth\Events\Login;

class ComposerServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        // ⬅️ Áp dụng cho các Views cần dữ liệu chung (Layout, Trang chủ, Kết quả tìm kiếm)
        View::composer(
            [
                'client.layouts.app',
                // Thêm các Views khác nếu cần
            ],
            function ($view) {
                // 1. Lấy danh sách Danh mục
                $danhmuc = DanhmucModel::select('ten', 'logo','slug')->orderBy('sapxep', 'desc')->get();

                // 2. Lấy Từ khóa Placeholder ngẫu nhiên từ TOP 15
                $tukhoaplaceholder = null;
                $top15tukhoa = TukhoaModel::orderBy('luottruycap', 'asc')->take(15)->get();
                if ($top15tukhoa->isNotEmpty()) {
                    $tukhoaplaceholder = $top15tukhoa->random()->tukhoa;
                }

                // 3. Lấy 5 Từ khóa Phổ biến (Top 5)
                $tukhoaphobien = TukhoaModel::select('tukhoa')->orderBy('luottruycap', 'desc')->take(5)->get();

                $giohangauth = GiohangModel::where('id_nguoidung', Auth::id())->get();
                $giohangsession = Session::get('cart', []);

                

                // 4. Truyền dữ liệu vào View
                $view->with(compact('danhmuc', 'tukhoaplaceholder', 'tukhoaphobien', 'giohangauth', 'giohangsession'));
            }
        );

        View::composer(
            [
                'admin.layouts.app',
                // Thêm các Views khác nếu cần
            ],
            function ($view) {
                // 1. Lấy danh sách Danh mục
                $donhangs = DonhangModel::get();

                // 4. Truyền dữ liệu vào View
                $view->with(compact('donhangs'));
            }
        );
    }

    protected $listen = [
        Login::class => [
            MergeCartOnLogin::class,
        ],
    ];
}
