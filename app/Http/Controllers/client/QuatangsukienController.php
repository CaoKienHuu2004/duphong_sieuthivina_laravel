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
        $quatang->increment('luotxem');
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

    public function themgiohang(Request $request)
    {
        // 1. Validate dữ liệu đầu vào
        $request->validate([
            'id_bienthe' => 'required|exists:bienthe,id',
            'soluong' => 'required|integer|min:1',
        ]);

        $id_bienthe = $request->input('id_bienthe');
        $soluong_them = $request->input('soluong');

        // Lấy thông tin biến thể VÀ eagerly load sanpham
        $bienthe = BientheModel::with('sanpham')->find($id_bienthe); 
        
        if (!$bienthe) {
            // Trả về view blade return back()
            return back()->withErrors(['message' => 'Biến thể sản phẩm không tồn tại.']);
        }

        $giaban = $bienthe->giadagiam; // Giá đã giảm (Accessor)
        $tonkho_hientai = $bienthe->soluong; // Số lượng tồn kho
        $soluong_daco = 0; 
        $cart = Session::get('cart', []); // Khởi tạo cart cho Guest

        // --- 2. XÁC ĐỊNH SỐ LƯỢNG ĐÃ CÓ VÀ KIỂM TRA TỒN KHO ---
        if (Auth::check()) {
            // AUTH: Kiểm tra trong Database
            $id_nguoidung = Auth::id();
            $giohang_item_db = GiohangModel::where('id_nguoidung', $id_nguoidung)
                                          ->where('id_bienthe', $id_bienthe)
                                          ->first();
            if ($giohang_item_db) {
                $soluong_daco = $giohang_item_db->soluong;
            }
        } else {
            // GUEST: Kiểm tra trong Session
            if (isset($cart[$id_bienthe])) {
                $soluong_daco = $cart[$id_bienthe]['soluong'];
            }
        }
        
        $tong_soluong_moi = $soluong_daco + $soluong_them;

        if ($tong_soluong_moi > $tonkho_hientai) {
             $con_lai = $tonkho_hientai - $soluong_daco;
             $message_error = "Xin lỗi, số lượng tồn kho chỉ còn $tonkho_hientai sản phẩm. Bạn chỉ có thể thêm tối đa $con_lai sản phẩm nữa.";
             
             // Trả về view blade return back() lỗi tồn kho
             return back()->withErrors(['message' => $message_error]);
            
        }
        
        // --- 3. TIẾN HÀNH THÊM HOẶC CẬP NHẬT GIỎ HÀNG ---
        
        if (Auth::check()) {
            // 3a. ĐÃ ĐĂNG NHẬP (Lưu vào Database)
            if (isset($giohang_item_db)) {
                // Cập nhật
                $giohang_item_db->soluong = $tong_soluong_moi;
                $giohang_item_db->thanhtien = $tong_soluong_moi * $giaban;
                $giohang_item_db->save();
                $success = 'Đã cập nhật số lượng sản phẩm trong giỏ hàng!';
                
            } else {
                // Thêm mới
                $giohang_item_db = GiohangModel::create([
                    'id_nguoidung' => $id_nguoidung,
                    'id_bienthe' => $id_bienthe,
                    'soluong' => $soluong_them,
                    'thanhtien' => $soluong_them * $giaban,
                    'trangthai' => 'Hiển thị',
                ]);
                $success = 'Đã thêm sản phẩm vào giỏ hàng !';
            }
            // Không trả về $cart (Session) trong trường hợp Auth, mà trả về Database Cart hoặc thông báo.
            $data_response = $giohang_item_db; // Có thể trả về item vừa được tạo/cập nhật

        } else {
            // 3b. CHƯA ĐĂNG NHẬP (Lưu vào Session)
            if (isset($cart[$id_bienthe])) {
                // Cập nhật
                $cart[$id_bienthe]['soluong'] = $tong_soluong_moi;
                $cart[$id_bienthe]['giaban'] = $giaban; // Cập nhật lại giá
                $cart[$id_bienthe]['thanhtien'] = $tong_soluong_moi * $giaban; 
                $success = 'Đã cập nhật số lượng sản phẩm trong giỏ hàng !';
            } else {
                // Thêm mới
                $cart[$id_bienthe] = [
                    'id_bienthe' => $id_bienthe,
                    'soluong' => $soluong_them,
                    'giaban' => $giaban, // <-- THÊM THUỘC TÍNH GIÁ BÁN
                    'thanhtien' => $soluong_them * $giaban,
                    'trangthai' => 'Hiển thị',
                ];
                $success = 'Đã thêm sản phẩm vào giỏ hàng !';
            }

            Session::put('cart', $cart); // Lưu lại Session
            $data_response = $cart; // Trả về toàn bộ Session Cart
        }
        // trả về return back()
        return back()->with([
            'success' => $success, 
            // 'error' => $message,
        ]);
        
        // Hoặc đơn giản hơn, nếu Route hiển thị trang giỏ hàng là /gio-hang:
        // return redirect('/gio-hang')->with([
        //     'status' => 'success', 
        //     'message' => $message 
        // ]);
    }
}
