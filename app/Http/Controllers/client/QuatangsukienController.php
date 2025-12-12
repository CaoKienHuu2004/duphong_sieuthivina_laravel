<?php

namespace App\Http\Controllers\client;

use App\Http\Controllers\Controller;
use App\Models\QuatangsukienModel;
use App\Models\ThuonghieuModel;
use App\Models\BientheModel;
use App\Models\GiohangModel;
use App\Models\SanphamthamgiaQuatangModel; // Model sản phẩm điều kiện (phải mua)
use App\Models\SanphamduoctangQuatangModel; // Model sản phẩm quà tặng (được nhận)
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\Builder;

class QuatangsukienController extends Controller
{
    /**
     * Hiển thị danh sách các chương trình quà tặng
     */
    public function index(Request $request)
    {
        // 1. Tự động ẩn các chương trình mà TẤT CẢ quà tặng đều hết hàng (luottang <= 0)
        // Logic: Tìm những sự kiện KHÔNG CÓ món quà nào còn lượt tặng > 0
        QuatangsukienModel::where('trangthai', 'Hiển thị')
            ->whereDoesntHave('sanphamduoctang', function (Builder $query) {
                // $query đại diện cho BientheModel (do quan hệ belongsToMany)
                // Kiểm tra cột luottang trực tiếp trên bảng bienthe
                $query->where('luottang', '>', 0);
            })
            ->update(['trangthai' => 'Tạm ẩn']);

        // 2. Query lấy danh sách hiển thị
        // Eager load sâu để lấy ảnh và thương hiệu của quà tặng
        $query = QuatangsukienModel::with([
            'sanphamduoctang.sanpham.thuonghieu',
            'sanphamduoctang.sanpham.hinhanhsanpham' 
        ])
        ->where('trangthai', 'Hiển thị')
        ->where('deleted_at', null);

        // Lọc theo Nhà cung cấp (Lấy các sự kiện có quà thuộc thương hiệu này)
        if ($request->filled('provider')) {
            $thuonghieuId = $request->provider;
            $query->whereHas('sanphamduoctang.sanpham', function ($q) use ($thuonghieuId) {
                $q->where('id_thuonghieu', $thuonghieuId);
            });
        }

        // Sắp xếp
        $sort = $request->input('sort', 'popular');
        switch ($sort) {
            case 'newest': $query->orderBy('ngaybatdau', 'desc'); break;
            case 'expiring': $query->where('ngayketthuc', '>=', now())->orderBy('ngayketthuc', 'asc'); break;
            default: $query->orderBy('luotxem', 'desc'); break;
        }

        $quatang = $query->paginate(12)->withQueryString();

        // Lấy danh sách Thương hiệu có quà tặng để hiển thị Sidebar
        // Code sửa lại:
        $providers = ThuonghieuModel::whereHas('sanpham.bienthe.sanphamduoctang', function ($q) {
            // $q ở đây chính là QuatangsukienModel (do quan hệ sâu)
            $q->where('trangthai', 'Hiển thị');
        })->get();

        return view('client.quatang.index', compact('quatang', 'providers'));
    }

    /**
     * Hiển thị chi tiết một chương trình quà tặng
     */
    public function show($slug)
    {
        // 1. Lấy thông tin sự kiện & Danh sách quà tặng kèm theo
        $quatang = QuatangsukienModel::with([
            'sanphamduoctang.sanpham.thuonghieu',
            'sanphamduoctang.sanpham.hinhanhsanpham',
            'sanphamduoctang.loaibienthe'
        ])->where('slug', $slug)->firstOrFail();

        // 2. Kiểm tra tồn kho: Phải có ít nhất 1 món quà còn lượt tặng > 0
        $hasStock = false;
        // $quatang->sanphamduoctang trả về Collection các BientheModel
        foreach($quatang->sanphamduoctang as $bientheQua) {
            if ($bientheQua->luottang > 0) {
                $hasStock = true;
                break;
            }
        }

        if (!$hasStock) {
            $quatang->update(['trangthai' => 'Tạm ẩn']);
            return redirect()->route('qua-tang')->with('error', 'Chương trình này đã hết quà tặng.');
        }

        $quatang->increment('luotxem');

        // 3. Xác định "Quà Đại Diện" để hiển thị thông tin chính (Hình ảnh, Brand) ra View
        // Lấy món quà đầu tiên trong danh sách làm đại diện
        $representativeGift = $quatang->sanphamduoctang->first();
        
        if (!$representativeGift) {
             return redirect()->route('qua-tang')->with('error', 'Dữ liệu quà tặng không hợp lệ.');
        }

        // Gán quan hệ 'bienthe' giả lập cho $quatang để View cũ (dùng $quatang->bienthe) không bị lỗi
        // Lưu ý: View nên được cập nhật để loop qua $quatang->sanphamduoctang thay vì dùng bienthe đơn lẻ
        $quatang->setRelation('bienthe', $representativeGift); 

        $giftProduct = $representativeGift->sanpham;
        $requiredBrandId = $giftProduct->id_thuonghieu;
        $brandName = $giftProduct->thuonghieu->ten ?? 'Nhà cung cấp';

        // 4. Lấy điều kiện chương trình
        $targetCount = $quatang->dieukiensoluong;    
        $targetValue = $quatang->dieukiengiatri ?? 0;

        // 5. Lấy danh sách ID sản phẩm THAM GIA (Khách phải mua những món này)
        $participatingIds = SanphamthamgiaQuatangModel::where('id_quatang', $quatang->id)
                                ->pluck('id_bienthe')
                                ->toArray();

        // 6. Tính toán tiến độ dựa trên giỏ hàng hiện tại
        $metrics = $this->calculateCartMetrics($participatingIds, $requiredBrandId);
        $currentCount = $metrics['count'];
        $cartTotalValue = $metrics['totalValue'];
        $cartBientheIds = $metrics['cartIds'];

        // Tính % Hoàn thành
        $percentCount = ($targetCount > 0) ? ($currentCount / $targetCount) * 100 : 100;
        $percentValue = ($targetValue > 0) ? ($cartTotalValue / $targetValue) * 100 : 100;
        $percent = min($percentCount, $percentValue);
        $percent = min(100, $percent); 

        // Tính phần còn thiếu
        $remaining = max(0, $targetCount - $currentCount); 
        $remainingValue = max(0, $targetValue - $cartTotalValue); 

        // 7. Lấy danh sách sản phẩm gợi ý để khách mua thêm
        $suggestedQuery = BientheModel::with(['sanpham.hinhanhsanpham', 'loaibienthe'])
            ->whereIn('trangthai', ['Còn hàng', 'Sắp hết hàng'])
            ->where('soluong', '>', 0)
            ->whereNotIn('id', $cartBientheIds); // Không gợi ý món đã có trong giỏ

        // Nếu có danh sách tham gia cụ thể -> chỉ gợi ý món trong danh sách đó
        if (count($participatingIds) > 0) {
            $suggestedQuery->whereIn('id', $participatingIds);
        } else {
            // Fallback: Gợi ý theo thương hiệu
            $suggestedQuery->whereHas('sanpham', function ($q) use ($requiredBrandId) {
                $q->where('id_thuonghieu', $requiredBrandId);
            });
        }

        $suggestedProducts = $suggestedQuery->inRandomOrder()->take(10)->get();

        return view('client.quatang.chitiet', compact(
            'quatang',
            'percent',
            'currentCount',
            'targetCount',
            'cartTotalValue',
            'targetValue',
            'remaining',
            'remainingValue',
            'brandName',
            'suggestedProducts'
        ));
    }

    /**
     * Hàm phụ trợ: Tính toán số lượng và tổng tiền các sản phẩm hợp lệ trong giỏ hàng
     */
    private function calculateCartMetrics(array $participatingIds, int $brandId)
    {
        $count = 0;
        $totalValue = 0;
        $cartIds = [];
        $hasSpecificList = count($participatingIds) > 0;
        $cartItems = [];

        // Lấy dữ liệu giỏ hàng (DB hoặc Session)
        if (Auth::check()) {
            $cartItems = GiohangModel::with('bienthe.sanpham')
                ->where('id_nguoidung', Auth::id())
                ->where('thanhtien', '>', 0) // Chỉ tính hàng mua
                ->get();
        } else {
            $sessionCart = Session::get('cart', []);
            foreach ($sessionCart as $item) {
                if (($item['thanhtien'] ?? 0) <= 0) continue;
                
                $bienthe = BientheModel::with('sanpham')->find($item['id_bienthe']);
                if ($bienthe) {
                    $cartItems[] = (object) [
                        'id_bienthe' => $item['id_bienthe'],
                        'soluong' => $item['soluong'],
                        'thanhtien' => $item['thanhtien'],
                        'bienthe' => $bienthe
                    ];
                }
            }
        }

        // Duyệt qua từng món trong giỏ để kiểm tra điều kiện
        foreach ($cartItems as $item) {
            $isEligible = false;
            
            if ($hasSpecificList) {
                // Nếu có danh sách cụ thể: Check ID
                if (in_array($item->id_bienthe, $participatingIds)) $isEligible = true;
            } else {
                // Fallback: Check Thương hiệu
                if (isset($item->bienthe->sanpham) && $item->bienthe->sanpham->id_thuonghieu == $brandId) $isEligible = true;
            }

            if ($isEligible) {
                $count += $item->soluong;
                $totalValue += $item->thanhtien;
                $cartIds[] = $item->id_bienthe;
            }
        }

        return ['count' => $count, 'totalValue' => $totalValue, 'cartIds' => array_unique($cartIds)];
    }

    /**
     * Xử lý thêm sản phẩm vào giỏ hàng (từ trang chi tiết quà tặng)
     */
    public function themgiohang(Request $request)
    {
        $request->validate([
            'id_bienthe' => 'required|exists:bienthe,id',
            'soluong' => 'required|integer|min:1',
        ]);

        $id_bienthe = $request->input('id_bienthe');
        $soluong_them = $request->input('soluong');

        $bienthe = BientheModel::with('sanpham')->find($id_bienthe); 
        if (!$bienthe) return back()->withErrors(['message' => 'Biến thể sản phẩm không tồn tại.']);

        $giaban = $bienthe->giadagiam; 
        $tonkho_hientai = $bienthe->soluong; 
        $soluong_daco = 0; 
        $cart = Session::get('cart', []); 

        // Kiểm tra số lượng đã có trong giỏ
        if (Auth::check()) {
            $giohang_item_db = GiohangModel::where('id_nguoidung', Auth::id())
                                            ->where('id_bienthe', $id_bienthe)
                                            ->where('thanhtien', '>', 0)
                                            ->first();
            if ($giohang_item_db) $soluong_daco = $giohang_item_db->soluong;
        } else {
            if (isset($cart[$id_bienthe])) $soluong_daco = $cart[$id_bienthe]['soluong'];
        }
        
        $tong_soluong_moi = $soluong_daco + $soluong_them;

        // Kiểm tra tồn kho sản phẩm mua
        if ($tong_soluong_moi > $tonkho_hientai) {
             $con_lai = max(0, $tonkho_hientai - $soluong_daco);
             return back()->withErrors(['message' => "Xin lỗi, số lượng tồn kho chỉ còn $tonkho_hientai sản phẩm. Bạn chỉ có thể thêm tối đa $con_lai sản phẩm nữa."]);
        }
        
        // Thêm/Update Giỏ hàng
        if (Auth::check()) {
            if (isset($giohang_item_db)) {
                $giohang_item_db->update([
                    'soluong' => $tong_soluong_moi,
                    'thanhtien' => $tong_soluong_moi * $giaban
                ]);
            } else {
                GiohangModel::create([
                    'id_nguoidung' => Auth::id(), 'id_bienthe' => $id_bienthe,
                    'soluong' => $soluong_them, 'thanhtien' => $soluong_them * $giaban, 'trangthai' => 'Hiển thị',
                ]);
            }
            $success = 'Đã cập nhật số lượng sản phẩm trong giỏ hàng!';
        } else {
            $cart[$id_bienthe] = [
                'id_bienthe' => $id_bienthe, 'soluong' => $tong_soluong_moi,
                'giaban' => $giaban, 'thanhtien' => $tong_soluong_moi * $giaban, 'trangthai' => 'Hiển thị',
            ];
            Session::put('cart', $cart); 
            $success = 'Đã thêm sản phẩm vào giỏ hàng !';
        }

        return back()->with(['success' => $success]);
    }
}