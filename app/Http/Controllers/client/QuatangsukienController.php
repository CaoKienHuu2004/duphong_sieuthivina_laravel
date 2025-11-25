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

        QuatangsukienModel::where('trangthai', 'Hiển thị')
            ->whereHas('bienthe', function ($q) {
                $q->where('luottang', '<=', 0); // Điều kiện: Hết lượt tặng
            })
            ->update(['trangthai' => 'Tạm ẩn']);

        // 1. Khởi tạo Query và Eager Load để tránh n+1 query
        // Load sẵn bienthe -> sanpham -> thuonghieu để hiển thị ra view cho mượt
        $query = QuatangsukienModel::with(['bienthe.sanpham.thuonghieu'])
            ->where('trangthai', 'Hiển thị')
            ->where('deleted_at',null); // Giả sử chỉ lấy quà đang active

        

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

        // Kiểm tra tồn kho quà tặng (luottang)
        if ($quatang->bienthe->luottang <= 0) {
            $quatang->trangthai = 'Tạm ẩn';
            $quatang->save();
            return redirect()->back()->withErrors(['message' => 'Quà tặng này hiện không còn sẵn có.']);
        }

        $quatang->increment('luotxem');
        
        $giftProduct = $quatang->bienthe->sanpham;
        $requiredBrandId = $giftProduct->id_thuonghieu;
        $brandName = $giftProduct->thuonghieu->ten ?? 'Nhà cung cấp';
        
        // --- LẤY ĐIỀU KIỆN ---
        $targetCount = $quatang->dieukiensoluong;        // Điều kiện 1: Số lượng SP khác nhau
        $targetValue = $quatang->dieukiengiatri ?? 0; // Điều kiện 2: Tổng giá trị đơn hàng (MỚI)

        // 2. Lấy thông tin Giỏ hàng hiện tại
        $cartBientheIds = $this->getCartBientheIds();   // Lấy danh sách ID để check số lượng
        $cartTotalValue = $this->getCartTotalValue();   // Lấy tổng tiền để check giá trị (MỚI)

        // 3. Tính toán tiến độ
        
        // a. Tiến độ theo Số lượng SP khác nhau
        $currentCount = 0;
        if (!empty($cartBientheIds)) {
            $currentCount = BientheModel::whereIn('id', $cartBientheIds)
                ->whereHas('sanpham', function ($q) use ($requiredBrandId) {
                    $q->where('id_thuonghieu', $requiredBrandId);
                })
                ->count();
        }
        $percentCount = ($targetCount > 0) ? ($currentCount / $targetCount) * 100 : 100;

        // b. Tiến độ theo Giá trị đơn hàng (MỚI)
        // Nếu targetValue = 0 thì coi như luôn đạt 100%
        $percentValue = ($targetValue > 0) ? ($cartTotalValue / $targetValue) * 100 : 100;

        // c. Tổng hợp % hiển thị (Lấy cái thấp hơn để hiển thị tiến độ thực tế)
        // Ví dụ: Đủ tiền (100%) nhưng thiếu số lượng (50%) -> Hiển thị 50%
        $percent = min($percentCount, $percentValue);
        $percent = min(100, $percent); // Tối đa 100%

        // d. Tính phần còn thiếu
        $remaining = max(0, $targetCount - $currentCount); // Còn thiếu bao nhiêu SP
        $remainingValue = max(0, $targetValue - $cartTotalValue); // Còn thiếu bao nhiêu tiền (MỚI)

        // 4. Lấy danh sách Gợi ý
        $suggestedProducts = BientheModel::with(['sanpham.hinhanhsanpham', 'loaibienthe'])
            ->whereHas('sanpham', function ($query) use ($requiredBrandId) {
                $query->where('id_thuonghieu', $requiredBrandId);
            })
            ->whereIn('trangthai', ['Còn hàng', 'Sắp hết hàng'])
            ->where('soluong', '>', 0)
            ->whereNotIn('id', $cartBientheIds)
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
            'suggestedProducts',
            // Truyền thêm biến mới ra View để hiển thị thông báo "Cần mua thêm X tiền"
            'cartTotalValue',
            'targetValue',
            'remainingValue'
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

    private function getCartTotalValue()
    {
        if (Auth::check()) {
            return GiohangModel::where('id_nguoidung', Auth::id())
                ->where('thanhtien', '>', 0) // Chỉ tính hàng mua, không tính quà
                ->sum('thanhtien');
        } else {
            $sessionCart = Session::get('cart', []);
            $total = 0;
            foreach ($sessionCart as $item) {
                if (($item['thanhtien'] ?? 0) > 0) {
                    $total += $item['thanhtien'];
                }
            }
            return $total;
        }
    }
}
