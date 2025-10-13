<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SellerDashboardController extends Controller
{
    /**
     * Hiển thị trang dashboard cho seller
     */
    public function index()
    {
        $nguoiDung = Auth::user();

        // Thống kê cho seller (chỉ sản phẩm và đơn hàng của seller này)
        $thongKe = [
            'my_products' => \App\Models\SanphamModel::whereHas('cuahang', function ($query) use ($nguoiDung) {
                $query->where('cuahang.id', $nguoiDung->id);
            })->count(),
            'my_orders' => \App\Models\DonhangModel::whereHas('chitietdonhang', function($query) use ($nguoiDung) {
                $query->whereHas('sanpham', function($q) use ($nguoiDung) {
                    $q->where('id_nguoidung', $nguoiDung->id);
                });
            })->count(),
            'pending_orders' => 0, // Có thể tính từ đơn hàng chưa xử lý
            'total_revenue' => 0, // Có thể tính từ đơn hàng đã hoàn thành
        ];

        return view('seller.seller-dashboard', compact('nguoiDung', 'thongKe'));
    }
}
