<?php

namespace Database\Seeders;

use App\Models\NguoidungModel;
use App\Models\SanphamModel;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class SanphamSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
   public function run()
    {
        // 1. Tìm ID của Seller đã được tạo trong UserSeeder
        // Giả định rằng cột 'role' được sử dụng để phân biệt Seller
        $seller = NguoidungModel::where('vaitro', 'seller')->first();

        // Kiểm tra an toàn
        if (!$seller) {
            echo "Lỗi: Không tìm thấy người dùng Seller. Vui lòng chạy UserSeeder trước.";
            return;
        }

        $sellerId = $seller->id;

        // 2. Tạo các Sản phẩm mẫu
        SanphamModel::create([
            'id_nguoidung' => $sellerId, // Liên kết sản phẩm với Seller
            'name' => 'Áo Thun Cotton Cao Cấp',
            'description' => 'Áo thun 100% cotton, co giãn 4 chiều, thoáng mát, thích hợp mặc hàng ngày.',
            'price' => 199000.00,
            'stock' => 150,
            'status' => 'published', // Trạng thái: đang bán
            'deleted_at' => null,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        SanphamModel::create([
            'user_id' => $sellerId,
            'name' => 'Bàn Phím Cơ Gaming RGB',
            'description' => 'Bàn phím cơ Blue Switch, đèn LED RGB 16.8 triệu màu, độ bền cao.',
            'price' => 850000.00,
            'stock' => 50,
            'status' => 'published',
            'deleted_at' => null,
            'created_at' => now()->subDays(5),
            'updated_at' => now()->subDays(2),
        ]);

        SanphamModel::create([
            'user_id' => $sellerId,
            'name' => 'Tai Nghe Bluetooth Chống Ồn',
            'description' => 'Tai nghe không dây pin 24 giờ, công nghệ chống ồn chủ động (ANC).',
            'price' => 1500000.00,
            'stock' => 0, // Hết hàng
            'status' => 'out_of_stock', // Trạng thái: hết hàng
            'deleted_at' => null,
            'created_at' => now()->subMonth(),
            'updated_at' => now(),
        ]);
        
        // Sản phẩm bị xóa mềm (Soft Deleted)
        SanphamModel::create([
            'user_id' => $sellerId,
            'name' => 'Mẫu Thử Nghiệm Cũ',
            'description' => 'Sản phẩm đã ngừng kinh doanh, chỉ dùng để lưu trữ dữ liệu.',
            'price' => 10000.00,
            'stock' => 10,
            'status' => 'archived',
            'deleted_at' => now(), // Đã bị xóa mềm
            'created_at' => now()->subYear(),
            'updated_at' => now(),
        ]);
    }
}
