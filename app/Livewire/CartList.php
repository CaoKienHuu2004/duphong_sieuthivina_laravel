<?php

namespace App\Livewire;

use Livewire\Component;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\DB;
use App\Models\GiohangModel;
use App\Models\BientheModel;
use App\Models\QuatangsukienModel;
use App\Models\MagiamgiaModel;
use Carbon\Carbon;

class CartList extends Component
{
    // Thuộc tính Public (State)
    public $cartItems = [];         
    public $giftItems = [];         
    public $availableVouchers = []; 
    public $subtotal = 0;           
    public $total = 0;              
    public $appliedVoucherCode = null; 
    public $voucherDiscount = 0;    

    // Khởi tạo và tải dữ liệu khi component được mount
    public function mount()
    {
        $this->reloadAllData();
    }
    
    // =====================================================================
    // CORE LOGIC: Tải & Tính toán
    // =====================================================================

    // Hàm gọi tất cả các bước tải và tính toán lại
    public function reloadAllData()
    {
        $this->loadCart(); 
        $this->processGiftsAndStore(); // Xử lý quà tặng và lưu vào giỏ hàng
        $this->calculateTotals(); 
        $this->loadAvailableVouchers(); 
    }

    // Tải sản phẩm chính từ DB/Session (chỉ lấy thanhtien > 0)
    public function loadCart()
    {
        $this->cartItems = []; // Reset
        if (Auth::check()) {
            $this->cartItems = GiohangModel::with(['bienthe.sanpham.thuonghieu', 'bienthe.loaibienthe'])
                ->where('id_nguoidung', Auth::id())
                ->where('thanhtien', '>', 0) 
                ->get()
                ->toArray();
        } else {
            $sessionCart = Session::get('cart', []);
            foreach ($sessionCart as $id_bienthe => $item) {
                // Kiểm tra có phải sản phẩm chính không (thanhtien > 0)
                if (($item['thanhtien'] ?? 1) > 0) { 
                    $bienthe = BientheModel::with(['sanpham.thuonghieu', 'loaibienthe'])->find($id_bienthe);
                    if ($bienthe) {
                         $this->cartItems[] = [
                            'id_bienthe' => $id_bienthe,
                            'soluong' => $item['soluong'],
                            'thanhtien' => $item['thanhtien'],
                            'bienthe' => $bienthe->toArray(),
                        ];
                    }
                }
            }
        }
    }
    
    // Xử lý Quà tặng, Cập nhật vào DB/Session, và chuẩn bị để hiển thị
    public function processGiftsAndStore()
    {
        $this->giftItems = [];
        $giftBrandQuantities = []; 

        // 1. Tính tổng số lượng theo thương hiệu từ SẢN PHẨM CHÍNH
        foreach ($this->cartItems as $item) {
            $id_thuonghieu = $item['bienthe']['sanpham']['id_thuonghieu'];
            $giftBrandQuantities[$id_thuonghieu] = ($giftBrandQuantities[$id_thuonghieu] ?? 0) + $item['soluong'];
        }
        
        // 2. Lấy danh sách quà tặng khả dụng
        $currentDate = Carbon::now();
        $potentialGifts = QuatangsukienModel::with('bienthe.sanpham', 'bienthe.loaibienthe')
            ->where('trangthai', 'Hoạt động')
            ->where('ngaybatdau', '<=', $currentDate)
            ->where('ngayketthuc', '>=', $currentDate)
            ->get();

        // Danh sách quà tặng đủ điều kiện (để xóa những món không còn đủ)
        $qualifiedGiftIds = [];

        // 3. Xét điều kiện, cập nhật Giỏ hàng và danh sách hiển thị
        foreach ($potentialGifts as $gift) {
            $requiredQuantity = (int) $gift->dieukien;
            $giftProductBrandId = $gift->bienthe->sanpham->id_thuonghieu;
            $id_bienthe_gift = $gift->id_bienthe;

            if (isset($giftBrandQuantities[$giftProductBrandId]) && $giftBrandQuantities[$giftProductBrandId] >= $requiredQuantity) {
                // Đủ điều kiện: Thêm/Cập nhật quà tặng (giá 0đ, số lượng 1)
                $this->updateGiftCartItem($id_bienthe_gift, 1, 0); 
                $qualifiedGiftIds[] = $id_bienthe_gift; // Đánh dấu đủ điều kiện
                
                // Thêm vào danh sách hiển thị
                $this->giftItems[] = [
                    'id_bienthe' => $id_bienthe_gift,
                    'soluong' => 1,
                    'ten_sanpham' => $gift->bienthe->sanpham->ten . ' - ' . ($gift->bienthe->loaibienthe->ten ?? ''),
                    'tieude' => $gift->tieude,
                    'thongtin' => "Yêu cầu mua {$requiredQuantity} sản phẩm cùng thương hiệu '{$gift->bienthe->sanpham->thuonghieu->ten ?? 'N/A'}'.",
                ];
            }
        }
        
        // 4. Xóa các quà tặng không còn đủ điều kiện
        $this->cleanUpGifts($potentialGifts->pluck('id_bienthe')->toArray(), $qualifiedGiftIds);
    }

    // Hàm phụ: Thêm/Cập nhật Quà tặng vào DB/Session (thanhtien = 0)
    protected function updateGiftCartItem($id_bienthe, $soluong, $thanhtien)
    {
        if (Auth::check()) {
            GiohangModel::updateOrCreate(
                ['id_nguoidung' => Auth::id(), 'id_bienthe' => $id_bienthe],
                ['soluong' => $soluong, 'thanhtien' => $thanhtien, 'trangthai' => 'Hiển thị']
            );
        } else {
            $cart = Session::get('cart', []);
            $cart[$id_bienthe] = [
                'id_bienthe' => $id_bienthe,
                'soluong' => $soluong,
                'giaban' => 0, // Giá gốc 0đ
                'thanhtien' => $thanhtien, 
                'trangthai' => 'Hiển thị',
            ];
            Session::put('cart', $cart);
        }
    }
    
    // Hàm phụ: Dọn dẹp quà tặng không còn đủ điều kiện
    protected function cleanUpGifts(array $allPotentialGiftIds, array $qualifiedGiftIds)
    {
        $unqualifiedIds = array_diff($allPotentialGiftIds, $qualifiedGiftIds);
        
        foreach ($unqualifiedIds as $id_bienthe) {
            if (Auth::check()) {
                 GiohangModel::where('id_nguoidung', Auth::id())
                            ->where('id_bienthe', $id_bienthe)
                            ->where('thanhtien', 0) // Chỉ xóa quà tặng
                            ->delete();
            } else {
                $cart = Session::get('cart', []);
                if (isset($cart[$id_bienthe]) && ($cart[$id_bienthe]['thanhtien'] ?? 1) == 0) {
                     Session::forget('cart.' . $id_bienthe);
                }
            }
        }
    }

    // Tính tổng tiền Subtotal và Total
    public function calculateTotals()
    {
        $this->subtotal = collect($this->cartItems)->sum('thanhtien'); 
        
        $this->total = $this->subtotal - $this->voucherDiscount;
        if ($this->total < 0) {
            $this->total = 0;
        }
    }
    
    // Tải danh sách Voucher đủ điều kiện (min_amount)
    public function loadAvailableVouchers()
    {
        $currentDate = Carbon::now();
        $subtotalAmount = $this->subtotal; 
        
        $this->availableVouchers = MagiamgiaModel::where('trangthai', 'Hoạt động')
            ->where('ngaybatdau', '<=', $currentDate)
            ->where('ngayketthuc', '>=', $currentDate)
            ->get()
            ->filter(function ($voucher) use ($subtotalAmount) {
                return $subtotalAmount >= (float)$voucher->dieukien;
            })
            ->toArray();
    }
    
    // Áp dụng Voucher được chọn
    public function applyVoucher($code)
    {
        if (empty($code)) {
             $this->appliedVoucherCode = null;
             $this->voucherDiscount = 0;
             $this->calculateTotals();
             session()->flash('voucher_message', 'Đã hủy áp dụng mã giảm giá.');
             return;
        }
        
        $voucher = MagiamgiaModel::where('magiamgia', $code)->first();
            
        if (!$voucher || $this->subtotal < (float)$voucher->dieukien) {
             $this->appliedVoucherCode = null;
             $this->voucherDiscount = 0;
             $this->calculateTotals();
             session()->flash('voucher_message', 'Mã voucher không hợp lệ hoặc giỏ hàng không đủ điều kiện.');
             return;
        }
        
        $this->appliedVoucherCode = $code;
        $this->voucherDiscount = (float)$voucher->giatri;
        $this->calculateTotals();
        
        session()->flash('voucher_message', 'Đã áp dụng mã giảm giá **' . $code . '** thành công!');
    }
    
    // =====================================================================
    // USER INTERACTIONS: Cập nhật & Xóa (Livewire Actions)
    // =====================================================================
    
    // Cập nhật số lượng sản phẩm
    public function updateQuantity($id_bienthe, $newQuantity)
    {
        $newQuantity = (int)$newQuantity;
        if ($newQuantity < 1) {
            $this->removeItem($id_bienthe); // Xóa nếu số lượng là 0
            return;
        }

        $bienthe = BientheModel::find($id_bienthe);
        if (!$bienthe || $newQuantity > $bienthe->soluong) {
            session()->flash('error', 'Số lượng vượt quá tồn kho hiện tại.');
            return;
        }

        $giaban = $bienthe->giadagiam;
        $thanhtien = $newQuantity * $giaban;

        if (Auth::check()) {
            GiohangModel::where('id_nguoidung', Auth::id())
                        ->where('id_bienthe', $id_bienthe)
                        ->update(['soluong' => $newQuantity, 'thanhtien' => $thanhtien]);
        } else {
            $cart = Session::get('cart', []);
            if (isset($cart[$id_bienthe])) {
                $cart[$id_bienthe]['soluong'] = $newQuantity;
                $cart[$id_bienthe]['thanhtien'] = $thanhtien;
                Session::put('cart', $cart);
            }
        }
        
        // Cập nhật toàn bộ logic (Quà tặng có thể thay đổi)
        $this->reloadAllData(); 
        session()->flash('update_message', 'Đã cập nhật số lượng sản phẩm.');
    }

    // Xóa sản phẩm
    public function removeItem($id_bienthe)
    {
        if (Auth::check()) {
            GiohangModel::where('id_nguoidung', Auth::id())
                        ->where('id_bienthe', $id_bienthe)
                        ->delete();
        } else {
            Session::forget('cart.' . $id_bienthe);
        }

        // Cập nhật toàn bộ logic (Quà tặng có thể thay đổi)
        $this->reloadAllData(); 
        session()->flash('update_message', 'Đã xóa sản phẩm khỏi giỏ hàng.');
    }

    // Hàm render Livewire
    public function render()
    {
        return view('livewire.cart-list');
    }
}