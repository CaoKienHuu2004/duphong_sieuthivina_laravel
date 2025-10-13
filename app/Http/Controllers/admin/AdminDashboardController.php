<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminDashboardController extends Controller
{
    /**
     * Hiển thị trang dashboard cho admin
     */
    public function index()
    {
        $user = Auth::user();

        // Thống kê cơ bản (có thể thêm logic tính toán thực tế)
        $stats = [
            'total_users' => \App\Models\NguoidungModel::count(),
            'total_products' => \App\Models\SanphamModel::count(),
            'total_orders' => \App\Models\DonhangModel::count(),
            'total_revenue' => 0, // Có thể tính từ đơn hàng
        ];

        return view('admin.dashboard', compact('user', 'stats'));
    }
}
