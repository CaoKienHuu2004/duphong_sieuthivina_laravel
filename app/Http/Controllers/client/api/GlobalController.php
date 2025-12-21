<?php

namespace App\Http\Controllers\client\api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\DanhmucModel;
use App\Models\TukhoaModel;
use App\Models\GiohangModel;
use App\Models\SanphamModel; // Thêm model sản phẩm để làm chức năng tìm kiếm
use Illuminate\Support\Facades\DB;

class GlobalController extends Controller
{
    /**
     * 1. LẤY DỮ LIỆU CHUNG CHO HEADER (Thay thế ComposerServiceProvider)
     * API này Frontend sẽ gọi 1 lần khi load trang (Layout)
     * Method: GET
     */
    public function getHeaderData()
    {
        // 1. Lấy danh sách Danh mục (Menu)
        $danhmuc = DanhmucModel::select('id', 'ten', 'logo', 'slug')
            ->where('trangthai', 'Hiển thị') // Nên thêm điều kiện này cho chắc
            ->orderBy('sapxep', 'asc')
            ->get();

        // [MỚI] Duyệt qua danh sách để gắn đường dẫn asset cho logo
        $danhmuc->transform(function ($item) {
            if ($item->logo) {
                // Kiểm tra xem trong folder public của bạn, ảnh danh mục nằm ở đâu.
                // Thường là: assets/client/images/categories/
                $item->logo = asset('assets/client/images/categories/' . $item->logo);
            }
            return $item;
        });

        // 2. Lấy Từ khóa Placeholder ngẫu nhiên từ TOP 15
        $tukhoaplaceholder = "Tìm kiếm sản phẩm..."; // Mặc định
        $top15tukhoa = TukhoaModel::orderBy('luottruycap', 'desc')->take(15)->get();
        
        if ($top15tukhoa->isNotEmpty()) {
            $tukhoaplaceholder = $top15tukhoa->random()->tukhoa;
        }

        // 3. Lấy 5 Từ khóa Phổ biến (Top 5)
        $tukhoaphobien = TukhoaModel::select('tukhoa', 'luottruycap')
            ->orderBy('luottruycap', 'desc')
            ->take(5)
            ->get();

        // 4. Lấy số lượng giỏ hàng (Chỉ áp dụng cho User đã Login)
        // Lưu ý: Với API (Next.js), Backend không quản lý Session giỏ hàng của khách vãng lai.
        // Khách vãng lai sẽ lưu ở LocalStorage phía Frontend.
        $cartCount = 0;
        $cartItems = [];

        if (Auth::guard('sanctum')->check()) {
            $userId = Auth::guard('sanctum')->id();
            $cartItems = GiohangModel::where('id_nguoidung', $userId)->get();
            $cartCount = $cartItems->sum('soluong'); // Hoặc count() tùy logic bạn muốn hiển thị số dòng hay tổng số lượng
        }

        return response()->json([
            'status' => 200,
            'message' => 'Lấy dữ liệu header thành công',
            'data' => [
                'danhmuc' => $danhmuc,
                'tukhoa_placeholder' => $tukhoaplaceholder,
                'tukhoa_phobien' => $tukhoaphobien,
                'cart_auth_count' => $cartCount, // Frontend dùng cái này nếu user đã login
                // 'cart_auth_items' => $cartItems // Nếu muốn trả về chi tiết giỏ hàng luôn thì mở cái này
            ]
        ]);
    }
}