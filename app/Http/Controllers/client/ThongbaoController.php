<?php

namespace App\Http\Controllers\client;

use App\Http\Controllers\Controller;
use App\Models\ThongbaoModel;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class ThongbaoController extends Controller
{
    // show danh sách thông báo
    public function index(Request $request)
    {
        $userId = Auth::id();
        $perPage = 10; // Số lượng thông báo mỗi trang

        // --- 1. Truy vấn Đơn hàng ---
        $orderNotifications = ThongbaoModel::where('id_nguoidung', $userId)
            ->where('loaithongbao', 'Đơn hàng')
            ->orderBy('id', 'desc')
            // Sử dụng pageName để đảm bảo các link phân trang không bị trùng tên
            ->paginate($perPage, ['*'], 'orderPage'); 

        // --- 2. Truy vấn Mã khuyến mãi ---
        $promotionNotifications = ThongbaoModel::where('id_nguoidung', $userId)
            ->where('loaithongbao', 'Khuyến mãi')
            ->orderBy('id', 'desc')
            ->paginate($perPage, ['*'], 'promotionPage');

        // --- 3. Truy vấn Quà tặng ---
        $giftNotifications = ThongbaoModel::where('id_nguoidung', $userId)
            ->where('loaithongbao', 'Quà tặng')
            ->orderBy('id', 'desc')
            ->paginate($perPage, ['*'], 'giftPage');

        // --- 4. Truy vấn Hệ thống ---
        $systemNotifications = ThongbaoModel::where('id_nguoidung', $userId)
            ->where('loaithongbao', 'Hệ thống')
            ->orderBy('id', 'desc')
            ->paginate($perPage, ['*'], 'systemPage');
        
        // Bạn có thể chọn đánh dấu thông báo là đã đọc (markAsRead) ở đây hoặc trong một hàm AJAX riêng.

        return view('notifications.index', [
            'orderNotifications' => $orderNotifications,
            'promotionNotifications' => $promotionNotifications,
            'giftNotifications' => $giftNotifications,
            'systemNotifications' => $systemNotifications,
            'activeTab' => $request->get('tab', 'content-7'), // Giữ tab đang hoạt động
        ]);
    }
    
    // Thêm hàm đánh dấu đã đọc tất cả
    public function markAllAsRead()
    {
         ThongbaoModel::where('id_nguoidung', Auth::id())
             ->where('trangthai', 'Chưa đọc')
             ->update(['trangthai' => 'Đã đọc']);
             
         return redirect()->back()->with('success', 'Đã đánh dấu tất cả thông báo là đã đọc.');
    }
}
