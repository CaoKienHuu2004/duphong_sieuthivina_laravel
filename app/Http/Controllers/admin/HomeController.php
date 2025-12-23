<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\BientheModel;
use App\Models\DonhangModel;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        // CHỈ TÍNH ĐƠN ĐÃ HOÀN THÀNH
        $queryHoanThanh = DonhangModel::where('trangthai', 'Đã giao hàng')->where('trangthaithanhtoan', 'Đã thanh toán');

        // ===== TỔNG DOANH THU (MỌI THỜI GIAN) =====
        $tongDoanhThu = (int) $queryHoanThanh->clone()->sum('thanhtien');

        // ===== DOANH THU HÔM NAY (THEO NGÀY ĐẶT) =====
        $tongDoanhThuNgay = (int) $queryHoanThanh->clone()
            ->whereDate('created_at', Carbon::today())
            ->sum('thanhtien');

        // ===== DOANH THU TUẦN (THEO NGÀY ĐẶT) =====
        $startOfWeek = Carbon::now()->startOfWeek();
        $endOfWeek   = Carbon::now()->endOfWeek();

        $tongDoanhThuTuan = (int) $queryHoanThanh->clone()
            ->whereBetween('created_at', [$startOfWeek, $endOfWeek])
            ->sum('thanhtien');

        // ===== DOANH THU THÁNG (THEO NGÀY ĐẶT) =====
        $tongDoanhThuThang = (int) $queryHoanThanh->clone()
            ->whereMonth('created_at', Carbon::now()->month)
            ->whereYear('created_at', Carbon::now()->year)
            ->sum('thanhtien');

        // ===== ĐƠN HÀNG MỚI =====
        $donHangsMoi = DonhangModel::with(['nguoidung'])
            ->where('trangthai', 'Chờ xác nhận')
            ->orderByDesc('created_at')
            ->limit(5)
            ->get();

        // ===== SẢN PHẨM HẾT HÀNG =====
        $sanPhamHetHang = BientheModel::with('sanpham.hinhanhsanpham')
            ->whereHas('sanpham', function($q) {
                $q->whereNull('deleted_at'); // Đảm bảo sản phẩm cha chưa bị xóa
            })
            ->whereNull('deleted_at')
            ->where('soluong', '<', 10)
            ->orderBy('soluong', 'asc')
            ->take(5)
            ->get();

        // ===== SẢN PHẨM TỒN KHO =====
        $sanPhamTonKho = BientheModel::with(['sanpham'])
            ->whereHas('sanpham', function($q) {
                $q->whereNull('deleted_at'); // Đảm bảo sản phẩm cha chưa bị xóa
            })
            ->whereNull('deleted_at')
            ->where('soluong', '>', 100)
            ->orderBy('soluong', 'desc')
            ->take(5)
            ->get();


        return view('admin.trangchu', compact(
            'tongDoanhThu',
            'tongDoanhThuNgay',
            'tongDoanhThuTuan',
            'tongDoanhThuThang',
            'donHangsMoi',
            'sanPhamHetHang',
            'sanPhamTonKho'
        ));
    }

    public function getThongKeDoanhThu(Request $request)
    {
        $type = $request->get('type', 'week'); // week | month | year

        // CHỈ TÍNH ĐƠN ĐÃ HOÀN THÀNH & THANH TOÁN
        $baseQuery = DonhangModel::query()
            ->where('trangthai', 'Đã giao hàng')
            ->where('trangthaithanhtoan', 'Đã thanh toán'); // Quan trọng: Chỉ tính tiền thực nhận

        // ================== THEO TUẦN (7 ngày gần nhất) ==================
        if ($type === 'week') {
            $categories = [];
            $data = [];

            // Lặp 7 ngày từ quá khứ đến hôm nay
            for ($i = 6; $i >= 0; $i--) {
                $date = Carbon::today()->subDays($i);
                $categories[] = $date->format('d/m'); // Label trục X: 22/12

                // Query tính tổng tiền trong ngày đó
                $revenue = $baseQuery->clone()
                    ->whereDate('created_at', $date)
                    ->sum('thanhtien');
                
                $data[] = (int) $revenue;
            }

            return response()->json([
                'categories' => $categories,
                'series' => [['name' => 'Doanh thu', 'data' => $data]]
            ]);
        }

        // ================== THEO THÁNG (Chia 4 tuần) ==================
        if ($type === 'month') {
            $categories = ['Tuần 1', 'Tuần 2', 'Tuần 3', 'Tuần 4'];
            $data = [0, 0, 0, 0]; // Mặc định 4 tuần là 0

            $startOfMonth = Carbon::now()->startOfMonth();
            $endOfMonth = Carbon::now()->endOfMonth();

            $orders = $baseQuery->clone()
                ->whereBetween('created_at', [$startOfMonth, $endOfMonth])
                ->get();

            foreach ($orders as $order) {
                $day = $order->created_at->day;
                // Logic chia tuần đơn giản: 1-7: Tuần 1, 8-14: Tuần 2...
                if ($day <= 7) $index = 0;
                elseif ($day <= 14) $index = 1;
                elseif ($day <= 21) $index = 2;
                else $index = 3;

                $data[$index] += $order->thanhtien;
            }

            return response()->json([
                'categories' => $categories,
                'series' => [['name' => 'Doanh thu', 'data' => $data]]
            ]);
        }

        // ================== THEO NĂM (12 Tháng) ==================
        if ($type === 'year') {
            $categories = [];
            $data = [];

            // Query group by tháng (MySQL)
            $rows = $baseQuery->clone()
                ->whereYear('created_at', Carbon::now()->year)
                ->selectRaw("MONTH(created_at) as month, SUM(thanhtien) as total")
                ->groupBy('month')
                ->pluck('total', 'month') // Trả về mảng dạng [tháng => tiền]
                ->toArray();

            for ($m = 1; $m <= 12; $m++) {
                $categories[] = 'Thg ' . $m;
                $data[] = (int) ($rows[$m] ?? 0); // Nếu tháng đó không có doanh thu thì = 0
            }

            return response()->json([
                'categories' => $categories,
                'series' => [['name' => 'Doanh thu', 'data' => $data]]
            ]);
        }
    }
}
