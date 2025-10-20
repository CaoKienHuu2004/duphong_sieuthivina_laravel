<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;
use App\Models\DanhmucModel;
use App\Models\TukhoaModel;

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
                $danhmuc = DanhmucModel::select('ten', 'logo','slug')->get();

                // 2. Lấy Từ khóa Placeholder ngẫu nhiên từ TOP 15
                $tukhoaplaceholder = null;
                $top15tukhoa = TukhoaModel::orderBy('luottruycap', 'desc')->take(15)->get();
                if ($top15tukhoa->isNotEmpty()) {
                    $tukhoaplaceholder = $top15tukhoa->random()->tukhoa;
                }

                // 3. Lấy 5 Từ khóa Phổ biến (Top 5)
                $tukhoaphobien = TukhoaModel::select('tukhoa')->orderBy('luottruycap', 'desc')->take(5)->get();

                // 4. Truyền dữ liệu vào View
                $view->with(compact('danhmuc', 'tukhoaplaceholder', 'tukhoaphobien'));
            }
        );
    }
}
