<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Carbon;
use Spatie\Sitemap\Sitemap;
use Spatie\Sitemap\Tags\Url;

// **********************************************
// ĐẢM BẢO CÁC MODEL NÀY TỒN TẠI VÀ ĐƯỢC IMPORT ĐÚNG
// **********************************************
use App\Models\SanphamModel;
use App\Models\BaivietModel;
use App\Models\DanhmucModel;
use App\Models\ThuonghieuModel;
use App\Models\QuatangsukienModel; 
// Giả định Model cho bảng quatang_sukien là QuatangSukien

class GenerateSitemap extends Command
{
    protected $signature = 'sitemap:generate';
    protected $description = 'Tự động tạo và cập nhật sitemap.xml cho toàn bộ website.';

    public function handle()
    {
        $this->info('Bắt đầu tạo sitemap...');

        // 1. Khởi tạo Sitemap
        // Dùng config('app.url') để lấy URL gốc. Bạn cần đảm bảo APP_URL đã được cấu hình trong .env
        $sitemap = Sitemap::create(config('app.url')); 

        // --- 2. Thêm các URL tĩnh (Static Pages) dựa trên web.php ---
        // Trang chủ (Ưu tiên cao nhất: 1.0)
        $sitemap->add(Url::create(route('trang-chu'))->setPriority(1.0));

        // Các trang danh sách và trang quan trọng khác
        $sitemap->add(Url::create(route('danhsachsanpham'))->setPriority(0.9)); // /san-pham
        $sitemap->add(Url::create(route('danh-sach-bai-viet'))->setPriority(0.8)); // /bai-viet
        $sitemap->add(Url::create(route('gio-hang'))->setPriority(0.5));
        $sitemap->add(Url::create('/tim-kiem')->setPriority(0.5)); // Route tim-kiem

        // Các trang chính sách/liên hệ
        $sitemap->add(Url::create('/lien-he')->setPriority(0.6));
        $sitemap->add(Url::create('/chinh-sach-mua-hang')->setPriority(0.4)); 
        $sitemap->add(Url::create('/chinh-sach-nguoi-dung')->setPriority(0.4));
        $sitemap->add(Url::create('/dieu-khoan')->setPriority(0.4));


        // --- 3. Thêm các URL động (Dynamic Pages) từ Database ---

        // --- Chi tiết SẢN PHẨM ---
        SanphamModel::where('trangthai', 'Công khai')->get()->each(function (SanphamModel $sanpham) use ($sitemap) {
            $sitemap->add(
                Url::create(route('chi-tiet-san-pham', ['slug' => $sanpham->slug]))
                    // Khắc phục lỗi NULL date
                    ->setLastModificationDate($sanpham->updated_at ?? $sanpham->created_at ?? Carbon::now()) 
                    ->setChangeFrequency(Url::CHANGE_FREQUENCY_DAILY)
                    ->setPriority(0.8)
            );
        });

        // --- Chi tiết BÀI VIẾT ---
        BaivietModel::where('trangthai', 'Hiển thị')->get()->each(function (BaivietModel $baiviet) use ($sitemap) {
            $sitemap->add(
                Url::create(route('chi-tiet-bai-viet', ['slug' => $baiviet->slug]))
                    // Khắc phục lỗi NULL date
                    ->setLastModificationDate($baiviet->updated_at ?? $baiviet->created_at ?? Carbon::now()) 
                    ->setChangeFrequency(Url::CHANGE_FREQUENCY_WEEKLY)
                    ->setPriority(0.7)
            );
        });
        
        // --- Chi tiết QUÀ TẶNG/SỰ KIỆN ---
        QuatangSukienModel::where('trangthai', 'Hiển thị')->get()->each(function (QuatangSukienModel $event) use ($sitemap) {
            $sitemap->add(
                Url::create("/qua-tang/{$event->slug}")
                    // Khắc phục lỗi NULL date
                    ->setLastModificationDate($event->updated_at ?? $event->created_at ?? Carbon::now()) 
                    ->setChangeFrequency(Url::CHANGE_FREQUENCY_MONTHLY)
                    ->setPriority(0.6)
            );
        });

        // --- Danh mục dạng Query ---
        $baseProductUrl = route('danhsachsanpham');
        DanhmucModel::where('trangthai', 'Hiển thị')->get()->each(function (DanhmucModel $danhmuc) use ($sitemap, $baseProductUrl) {
            $sitemap->add(
                Url::create("{$baseProductUrl}?danhmuc={$danhmuc->slug}")
                    ->setChangeFrequency(Url::CHANGE_FREQUENCY_WEEKLY)
                    ->setPriority(0.7) 
            );
        });

        // --- Thương hiệu dạng Query ---
        ThuonghieuModel::where('trangthai', 'Hoạt động')->get()->each(function (ThuonghieuModel $thuonghieu) use ($sitemap, $baseProductUrl) {
            $sitemap->add(
                Url::create("{$baseProductUrl}?thuonghieu={$thuonghieu->slug}")
                    ->setChangeFrequency(Url::CHANGE_FREQUENCY_WEEKLY)
                    ->setPriority(0.6) 
            );
        });


        // --- 5. Ghi Sitemap ra file ---
        $sitemap->writeToFile(base_path('sitemap.xml'));

        $this->info('Sitemap đã được tạo thành công tại: ' . base_path('sitemap.xml'));

        return Command::SUCCESS;
    }
}