<?php

namespace App\Http\Controllers\client;

use App\Http\Controllers\Controller;
use App\Models\QuatangsukienModel;
use App\Models\ThuonghieuModel;
use App\Models\BientheModel;
use App\Models\GiohangModel;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Http\Request;

class QuatangsukienController extends Controller
{
    public function index(Request $request)
    {
        // 1. Khởi tạo Query và Eager Load để tránh n+1 query
        // Load sẵn bienthe -> sanpham -> thuonghieu để hiển thị ra view cho mượt
        $query = QuatangsukienModel::with(['bienthe.sanpham.thuonghieu'])
            ->where('trangthai', 'Hiển thị'); // Giả sử chỉ lấy quà đang active

        // =================================================================
        // LỌC THEO THƯƠNG HIỆU (NHÀ CUNG CẤP)
        // =================================================================
        // Logic: Check bảng Quatang -> Bienthe -> Sanpham -> check id_thuonghieu
        if ($request->filled('provider')) {
            $thuonghieuId = $request->provider;

            $query->whereHas('bienthe.sanpham', function ($q) use ($thuonghieuId) {
                $q->where('id_thuonghieu', $thuonghieuId);
            });
        }

        // =================================================================
        // SẮP XẾP (SORT)
        // =================================================================
        $sort = $request->input('sort', 'popular');

        switch ($sort) {
            case 'newest': // Mới nhất
                $query->orderBy('ngaybatdau', 'desc');
                break;

            case 'expiring': // Sắp hết hạn
                // Ưu tiên ngày kết thúc gần hiện tại nhất và phải lớn hơn hiện tại
                $query->where('ngayketthuc', '>=', now())
                    ->orderBy('ngayketthuc', 'asc');
                break;

            case 'popular': // Phổ biến
            default:
                $query->orderBy('luotxem', 'desc');
                break;
        }

        // 2. Lấy dữ liệu quà tặng (Phân trang 12 item)
        $quatang = $query->paginate(12)->withQueryString();

        // 3. Lấy danh sách Thương Hiệu cho Sidebar
        // Chỉ lấy những thương hiệu CÓ sản phẩm đang nằm trong chương trình quà tặng
        // Để tránh hiển thị thương hiệu rỗng không có quà nào
        $providers = ThuonghieuModel::whereHas('sanpham.bienthe.quatangsukien', function ($q) {
            $q->where('trangthai', 'Hiển thị');
        })->get();

        return view('client.quatang.index', compact('quatang', 'providers'));
    }

    public function show($slug)
    {
        // 1. Lấy thông tin quà tặng
        $quatang = QuatangsukienModel::with('bienthe.sanpham.thuonghieu')->where('slug', $slug)->firstOrFail();

        // Lấy thông tin thương hiệu yêu cầu từ sản phẩm quà tặng
        $giftProduct = $quatang->bienthe->sanpham;
        $requiredBrandId = $giftProduct->id_thuonghieu;
        $brandName = $giftProduct->thuonghieu->ten ?? 'Nhà cung cấp';
        $targetCount = $quatang->dieukien; // Số lượng biến thể cần mua

        // 2. Lấy danh sách ID các biến thể ĐANG CÓ trong giỏ hàng
        $cartBientheIds = $this->getCartBientheIds();

        // 3. Tính toán tiến độ (Đếm xem trong giỏ có bao nhiêu món thuộc Brand này)
        $currentCount = 0;

        if (!empty($cartBientheIds)) {
            // Query DB để check xem những món trong giỏ có thuộc Brand yêu cầu không
            $currentCount = BientheModel::whereIn('id', $cartBientheIds)
                ->whereHas('sanpham', function ($q) use ($requiredBrandId) {
                    $q->where('id_thuonghieu', $requiredBrandId);
                })
                ->count();
        }

        // Tính % hiển thị
        $percent = ($targetCount > 0) ? ($currentCount / $targetCount) * 100 : 0;
        $percent = min(100, $percent); // Tối đa 100%
        $remaining = max(0, $targetCount - $currentCount); // Số lượng còn thiếu

        // 4. Lấy danh sách Gợi ý (Cùng Brand, TRỪ những cái đã có trong giỏ)
        $suggestedProducts = BientheModel::with(['sanpham.hinhanhsanpham', 'loaibienthe'])
            ->whereHas('sanpham', function ($query) use ($requiredBrandId) {
                $query->where('id_thuonghieu', $requiredBrandId);
            })
            ->whereIn('trangthai', ['Còn hàng', 'Sắp hết hàng'])
            ->where('soluong', '>', 0) // Còn tồn kho thực tế
            ->whereNotIn('id', $cartBientheIds) // Trừ những cái đã mua
            ->inRandomOrder()
            ->take(10)
            ->get();

        return view('client.quatang.chitiet', compact(
            'quatang',
            'percent',
            'currentCount',
            'targetCount',
            'remaining',
            'brandName',
            'suggestedProducts'
        ));
    }

    // Hàm phụ trợ lấy ID giỏ hàng (Auth hoặc Session)
    private function getCartBientheIds()
    {
        $ids = [];
        if (Auth::check()) {
            $ids = GiohangModel::where('id_nguoidung', Auth::id())
                ->where('thanhtien', '>', 0) // Không lấy quà tặng
                ->pluck('id_bienthe')
                ->toArray();
        } else {
            $sessionCart = Session::get('cart', []);
            foreach ($sessionCart as $key => $item) {
                if (($item['thanhtien'] ?? 0) > 0) {
                    // Xử lý key session (nếu key là string '10_GIFT' thì bỏ qua, nếu là int ID thì lấy)
                    if (is_numeric($key)) {
                        $ids[] = (int) $key;
                    }
                }
            }
        }
        return array_unique($ids);
    }
}
