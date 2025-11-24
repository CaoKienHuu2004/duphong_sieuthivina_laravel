<?php

namespace App\Livewire;

use Livewire\Component;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use App\Models\MagiamgiaModel;
use App\Models\GiohangModel; 
use App\Models\BientheModel;
use App\Models\QuatangsukienModel; 

class GiohangComponent extends Component
{
    public $giohang = []; 
    public $tamtinh = 0; 
    public $tonggiatri = 0;
    public $tietkiem = 0;
    public $quatang = [];
    public $tongsoquatang = 0;
    public $voucherCode = ''; // Mã người dùng nhập vào form
    public $appliedVoucher = null; // Voucher đã áp dụng (Model hoặc array)
    public $giamgiaVoucher = 0; // Số tiền giảm từ voucher
    public $availableVouchers = []; // Danh sách voucher đủ điều kiện để hiển thị

    public function mount()
    {
        // 1. Tải Giỏ hàng & Xử lý Quà tặng (Để có dữ liệu cơ bản)
        $this->loadgiohang();
        $this->xoaTatCaQuatang(); 
        $this->xacnhandieukienquatang();
        
        // BƯỚC QUAN TRỌNG 1: Tính toán Tạm tính ($this->tamtinh) sau khi giỏ hàng ổn định
        $this->tonggiatri();
        
        // 2. Tải Voucher Đã Áp Dụng TỪ SESSION
        // Hàm này sẽ kiểm tra Session và gán giá trị cho $this->appliedVoucher.
        // Nếu voucher không hợp lệ (ví dụ: giỏ hàng không còn đủ điều kiện), nó sẽ bị xóa.
        $this->loadAppliedVoucher(); 
        
        // 3. Tính toán Tổng giá trị CUỐI CÙNG (áp dụng Voucher nếu $appliedVoucher != null)
        $this->tonggiatri(); 

        // 4. Tải danh sách voucher có thể áp dụng để hiển thị
        $this->loadAvailableVouchers();
    }

    /**
     * Tải giỏ hàng từ DB hoặc Session, bao gồm cả sản phẩm chính và quà tặng (thanhtien = 0).
     */
    public function loadgiohang()
    {
        $this->giohang = []; 

        if (Auth::check()) {
            $giohangdb = GiohangModel::with([
                'bienthe.sanpham.thuonghieu', 
                'bienthe.sanpham.hinhanhsanpham',
                'bienthe.loaibienthe'
            ])
            ->where('id_nguoidung', Auth::id())
            ->where('trangthai', 'Hien thi') 
            ->get();

            $this->giohang = $giohangdb->toArray();

        } else {
            // FIX CHO NGƯỜI DÙNG CHƯA ĐĂNG NHẬP: Xử lý khóa Session độc lập cho quà tặng
            $giohangsession = Session::get('cart', []);
            
            foreach ($giohangsession as $cartKey => $item) { // $cartKey có thể là '101' hoặc '101_GIFT_0D'
                // Tách ID biến thể thực tế từ khóa Session
                $id_bienthe_actual = (int)str_replace('_GIFT_0D', '', $cartKey); 

                if (($item['soluong'] ?? 0) > 0) { 
                    $bienthe = BientheModel::with([
                        'sanpham.thuonghieu',
                        'sanpham.hinhanhsanpham', 
                        'loaibienthe'
                    ])->find($id_bienthe_actual); // SỬ DỤNG ID THỰC TẾ

                    if ($bienthe) {
                        $isGift = ($item['thanhtien'] ?? 1) == 0;
                        $giaban = $isGift ? 0 : ($bienthe->giadagiam ?? $bienthe->giagoc);
                        
                        $this->giohang[] = [
                            'id_bienthe' => $id_bienthe_actual, // Luôn lưu ID biến thể thực tế
                            'soluong' => $item['soluong'],
                            // Giữ lại thanhtien nếu có từ session, tránh tính toán lại quà tặng 0đ
                            'thanhtien' => $item['thanhtien'] ?? ($item['soluong'] * $giaban), 
                            'bienthe' => $bienthe->toArray(),
                        ];
                    }
                }
            }
        }
        
        // Cập nhật $this->quatang bằng cách lọc $this->giohang có thanhtien = 0
        $this->quatang = array_filter($this->giohang, fn($item) => $item['thanhtien'] == 0);
    }

    private function xoaTatCaQuatang()
    {
        if (Auth::check()) {
            // Xóa quà tặng trong DB (những item có thanhtien = 0)
            GiohangModel::where('id_nguoidung', Auth::id())
                ->where('thanhtien', 0)
                ->delete();

        } else {
            // Xóa quà tặng trong Session
            $sessionCart = Session::get('cart', []);
            
            $sessionKeysToRemove = [];
            foreach ($sessionCart as $cartKey => $item) {
                // Quà tặng luôn được xác định bằng thanhtien = 0
                if (($item['thanhtien'] ?? 1) == 0) { 
                    $sessionKeysToRemove[] = $cartKey; // Lấy key chính xác
                }
            }
            
            foreach ($sessionKeysToRemove as $key) {
                unset($sessionCart[$key]);
            }
            
            Session::put('cart', $sessionCart);
        }

        // Tải lại giỏ hàng (chỉ cần tải lại từ DB/Session sau khi xóa quà tặng)
        $this->loadgiohang();
    }
    
    private function xacnhandieukienquatang()
    {
        $uniqueItemsByBrand = [];
        
        foreach ($this->giohang as $item) {
            // CHỈ XÉT SẢN PHẨM CHÍNH (có thành tiền > 0)
            if ($item['thanhtien'] > 0) { 
                $thuonghieuId = $item['bienthe']['sanpham']['id_thuonghieu'] ?? null;
                $bientheId = $item['id_bienthe'];
                
                if ($thuonghieuId) {
                    if (!isset($uniqueItemsByBrand[$thuonghieuId])) {
                        $uniqueItemsByBrand[$thuonghieuId] = [];
                    }
                    
                    $uniqueItemsByBrand[$thuonghieuId][$bientheId] = true;
                }
            }
        }

        $quatangsukiendb = QuatangsukienModel::all(); 
        $themquatang = []; 
        
        foreach ($quatangsukiendb as $rule) {
            $bientheduoctang = $rule->id_bienthe;
            $dieukienduoctang = $rule->dieukien; // Đây là "Số lượng sản phẩm khác nhau" cần mua
            
            $giftBienthe = BientheModel::with('sanpham')->find($bientheduoctang);
            
            if (!$giftBienthe) continue;

            $requiredBrandId = $giftBienthe->sanpham->id_thuonghieu ?? null;
            
            if ($requiredBrandId) {
                // TÍNH TOÁN: Lấy số lượng biến thể DUY NHẤT đang có của Thương hiệu đó
                $uniqueItemsCount = 0;
                if (isset($uniqueItemsByBrand[$requiredBrandId])) {
                    $uniqueItemsCount = count($uniqueItemsByBrand[$requiredBrandId]);
                }
                
                // KIỂM TRA ĐIỀU KIỆN MỚI: Nếu số lượng sản phẩm khác nhau >= điều kiện
                if ($uniqueItemsCount >= $dieukienduoctang) {
                    $soluongquatang = 1; 

                    if (!isset($themquatang[$bientheduoctang])) {
                        $themquatang[$bientheduoctang] = 0;
                    }
                    $themquatang[$bientheduoctang] = max($themquatang[$bientheduoctang], $soluongquatang);
                }
            }
        }
        
        foreach ($themquatang as $id_bienthe => $soluong) {
            if ($soluong > 0) {
                $this->addGiftToCart($id_bienthe, $soluong); 
            }
        }

        $this->loadgiohang();
    }

    private function addGiftToCart(int $bientheId, int $soluong)
    {
        $giftBienthe = BientheModel::with('sanpham')->find($bientheId);
        
        if (!$giftBienthe) return;
        
        // Kiểm tra xem quà tặng này đã có trong giỏ hàng chưa
        $isAlreadyInCart = false;
        foreach ($this->giohang as $item) {
            if ($item['id_bienthe'] == $bientheId && $item['thanhtien'] == 0) {
                $isAlreadyInCart = true;
                break;
            }
        }
        
        // Chỉ thêm nếu chưa có, vì Quà tặng cũ đã được xóa ở hàm xoaTatCaQuatang()
        if ($isAlreadyInCart) {
            return;
        }
        
        if (Auth::check()) {
            GiohangModel::updateOrCreate(
                [
                    'id_nguoidung' => Auth::id(),
                    'id_bienthe' => $bientheId,
                    'thanhtien' => 0, // Luôn đảm bảo là quà tặng (thanhtien = 0)
                ],
                [
                    'soluong' => $soluong, 
                    'trangthai' => 'Hien thi',
                ]
            );

        } else {
            // FIX CHO NGƯỜI DÙNG CHƯA ĐĂNG NHẬP: SỬ DỤNG KHÓA DUY NHẤT CHO QUÀ TẶNG
            $sessionCart = Session::get('cart', []);
            
            // Dùng key duy nhất cho quà tặng để tránh bị trùng với sản phẩm mua
            $giftKey = $bientheId . '_GIFT_0D'; 

            // Ghi đè quà tặng nếu tồn tại, hoặc thêm mới
            $sessionCart[$giftKey] = [
                'soluong' => $soluong,
                'thanhtien' => 0, // BẮT BUỘC thanhtien = 0 để phân biệt
            ];
            
            Session::put('cart', $sessionCart);
        }
    }


    public function tonggiatri()
    {
        $this->tamtinh = collect($this->giohang)->sum('thanhtien'); 
        
        $tongsanphamluutru = 0;
        $this->tongsoquatang = 0;
        
        foreach ($this->giohang as $item) {
            if ($item['thanhtien'] == 0) {
                $this->tongsoquatang += $item['soluong'];
                $giaGocQuatang = $item['bienthe']['giagoc'] ?? 0;
                $tongsanphamluutru += $giaGocQuatang * $item['soluong'];
            } else {
                $giaGoc = $item['bienthe']['giagoc'] ?? 0;
                $giaDaGiam = $item['bienthe']['giadagiam'] ?? $giaGoc;
                $giatritietkiem = max(0, $giaGoc - $giaDaGiam);
                $tongsanphamluutru += $giatritietkiem * $item['soluong'];
            }
        }
        
        $this->tietkiem = $tongsanphamluutru;
        $this->tonggiatri = $this->tamtinh; 

        $this->giamgiaVoucher = 0;

        if ($this->appliedVoucher) {
            $voucher = (object)$this->appliedVoucher; // Chuyển sang object để dễ truy cập
            
            // Tái kiểm tra điều kiện (phòng trường hợp người dùng xóa sản phẩm khiến tamtinh không đủ)
            if ($this->tamtinh >= $voucher->dieukien) {
                // Voucher của bạn đang dùng trường 'giatri'. Giả sử đây là số tiền giảm cố định (VND).
                $giamgia = (float) $voucher->giatri;
                
                // Đảm bảo số tiền giảm không vượt quá tổng giá trị giỏ hàng
                $this->giamgiaVoucher = min($giamgia, $this->tamtinh);
                
            } else {
                // Nếu không còn đủ điều kiện, hủy bỏ voucher
                $this->removeAppliedVoucher(true);
            }
        }

        // Cập nhật tổng giá trị cuối cùng
        $this->tonggiatri = $this->tamtinh - $this->giamgiaVoucher;
        
        // Cập nhật giá trị tiết kiệm (cộng thêm phần giảm từ voucher)
        $this->tietkiem += $this->giamgiaVoucher;

        // Tải lại danh sách voucher có thể áp dụng nếu tổng tiền thay đổi
        $this->loadAvailableVouchers();
    }

    public function capnhatsoluong($bientheId, $soluong)
    {
        $soluong = max(1, (int)$soluong);

        foreach ($this->giohang as $index => $item) {
            if ($item['id_bienthe'] == $bientheId) {
                if ($item['thanhtien'] == 0) {
                    session()->flash('error_message', "Không thể chỉnh sửa số lượng quà tặng.");
                    return; 
                }

                $soluonghientai = $this->giohang[$index]['soluong'];
                $giaban = $item['bienthe']['giadagiam'] ?? $item['bienthe']['giagoc'] ?? 0;

                $tonkho = $item['bienthe']['soluong'] ?? 0;
                if ($soluong > $tonkho) {
                    session()->flash('error_message', "Xin lỗi, số lượng tồn kho chỉ còn $tonkho sản phẩm. Không thể cập nhật số lượng lớn hơn.");
                    return; 
                }

                if ($soluonghientai != $soluong) {
                    $thanhtien_moi = $soluong * $giaban;
                    $this->giohang[$index]['soluong'] = $soluong;
                    $this->giohang[$index]['thanhtien'] = $thanhtien_moi;
                                             
                    $this->capnhatgiohang($bientheId, $soluong, $thanhtien_moi); 
                    
                    // BƯỚC QUAN TRỌNG: Kiểm tra lại quà tặng sau khi cập nhật số lượng
                    $this->xoaTatCaQuatang(); // Xóa quà tặng cũ
                    $this->xacnhandieukienquatang(); // Thêm quà tặng mới (nếu đủ điều kiện)
                    
                    $this->tonggiatri();

                    session()->flash('update_message', 'Đã cập nhật số lượng sản phẩm.');
                }
                return;
            }
        }
    }

    private function capnhatgiohang(int $bientheId, int $soluong, float $thanhtien)
    {
        if (Auth::check()) {
            // [LOGIC MỚI] Tìm dòng cụ thể để cập nhật thay vì update hàng loạt
            
            // 1. Tìm các sản phẩm trùng khớp (Lọc thanhtien > 0 để KHÔNG cập nhật nhầm vào dòng quà tặng 0đ)
            $cartItems = GiohangModel::where('id_nguoidung', Auth::id())
                ->where('id_bienthe', $bientheId)
                ->where('thanhtien', '>', 0) // Quan trọng: Chỉ lấy sản phẩm mua, không lấy quà tặng
                ->get();

            if ($cartItems->isEmpty()) {
                // Trường hợp hy hữu: không tìm thấy item nào (có thể đã bị xóa)
                return;
            }

            // 2. Lấy item đầu tiên để cập nhật
            $firstItem = $cartItems->first();
            $firstItem->update([
                'soluong' => $soluong,
                'thanhtien' => $thanhtien,
            ]);

            // 3. Nếu lỡ có các dòng trùng lặp khác (của cùng sản phẩm mua), xóa chúng đi
            if ($cartItems->count() > 1) {
                $idsToDelete = $cartItems->except($firstItem->id)->pluck('id');
                GiohangModel::destroy($idsToDelete);
            }

        } else {
            // Logic Session giữ nguyên, nhưng đảm bảo key chính xác
            $sessionCart = Session::get('cart', []);
            
            // Chỉ cập nhật sản phẩm MUA (key là id_bienthe)
            if (isset($sessionCart[$bientheId])) {
                $sessionCart[$bientheId]['soluong'] = $soluong;
                $sessionCart[$bientheId]['thanhtien'] = $thanhtien;
                Session::put('cart', $sessionCart);
            }
        }
    }

    public function xoagiohang($bientheId)
    {
        if (Auth::check()) {
            GiohangModel::where('id_nguoidung', Auth::id())
                ->where('id_bienthe', $bientheId)
                ->delete();

        } else {
            // FIX CHO NGƯỜI DÙNG CHƯA ĐĂNG NHẬP: Xóa cả hai loại key (Mua & Quà tặng)
            $sessionCart = Session::get('cart', []);
            
            $purchasedKey = (string)$bientheId;
            $giftKey = $bientheId . '_GIFT_0D';

            // Xóa item MUA (key là ID bienthe, nếu tồn tại)
            unset($sessionCart[$purchasedKey]);

            // Xóa item QUÀ TẶNG (key là ID bienthe + '_GIFT_0D', nếu tồn tại)
            unset($sessionCart[$giftKey]); 
            
            Session::put('cart', $sessionCart);
        }
        
        // Lọc lại mảng Livewire ($this->giohang)
        $this->giohang = array_filter($this->giohang, function ($item) use ($bientheId) {
            return $item['id_bienthe'] != $bientheId;
        });
        
        // BƯỚC QUAN TRỌNG: Kiểm tra lại quà tặng sau khi xóa sản phẩm chính
        $this->xoaTatCaQuatang(); // Xóa quà tặng cũ
        $this->xacnhandieukienquatang(); // Thêm quà tặng mới (nếu đủ điều kiện)

        $this->tonggiatri();
        session()->flash('update_message', 'Đã xóa sản phẩm khỏi giỏ hàng.');
    }

    /**
     * Tải voucher đã áp dụng từ Session và kiểm tra tính hợp lệ của nó.
     * Đây là bước then chốt để giữ trạng thái sau khi refresh trang.
     */
    private function loadAppliedVoucher()
    {
        // Lấy dữ liệu từ Session
        $voucherData = Session::get('applied_voucher', null); // <-- LẤY TỪ SESSION

        if ($voucherData) {
            $voucher = MagiamgiaModel::where('magiamgia', $voucherData['magiamgia'])->first();

            // Kiểm tra lại điều kiện, ngày hết hạn
            if ($voucher && $this->checkVoucherConditions($voucher, false)) { // Gửi false để không flash message
                $this->appliedVoucher = $voucher->toArray(); // <-- LƯU VÀO BIẾN LIVEWIRE
                $this->voucherCode = $voucher->magiamgia;
            } else {
                // Nếu không hợp lệ (ví dụ: đã hết hạn, giỏ hàng không đủ điều kiện), xóa nó khỏi Session
                $this->removeAppliedVoucher(false);
            }
        }
    }

    /**
     * Kiểm tra các điều kiện cơ bản của voucher
     */
    private function checkVoucherConditions($voucher, $flashMessage = true)
    {
        if (!$voucher || $voucher->trangthai !== 'Hoạt động') {
             if ($flashMessage) {
                 session()->flash('voucher_error', 'Mã giảm giá không hợp lệ hoặc không hoạt động.');
             }
            return false;
        }

        // Kiểm tra ngày hết hạn (nếu có trường ngayketthuc)
        if ($voucher->ngayketthuc && now()->gt($voucher->ngayketthuc)) {
             if ($flashMessage) {
                 session()->flash('voucher_error', 'Mã giảm giá đã hết hạn sử dụng.');
             }
            return false;
        }

        // Điều kiện tối thiểu: Tổng giá trị giỏ hàng (tamtinh) phải lớn hơn hoặc bằng điều kiện
        if ($this->tamtinh < $voucher->dieukien) {
            if ($flashMessage) {
                session()->flash('voucher_error', 'Giỏ hàng chưa đủ điều kiện (Giá trị tối thiểu: ' . number_format($voucher->dieukien,0,',','.') . ' ₫).');
            }
            return false;
        }

        return true;
    }

    /**
     * Lấy danh sách các voucher hợp lệ để hiển thị
     */
    public function loadAvailableVouchers()
    {
        // Lấy tất cả voucher đang hoạt động
        $allVouchers = MagiamgiaModel::where('trangthai', 'Hoạt động')
            ->where(function ($query) {
                // Thêm điều kiện ngày hết hạn nếu có
                $query->whereNull('ngayketthuc')
                      ->orWhere('ngayketthuc', '>=', now());
            })
            ->get();
            
        $this->availableVouchers = [];
        
        foreach ($allVouchers as $voucher) {
            // Chỉ hiển thị những voucher mà giỏ hàng đủ điều kiện áp dụng
            if ($this->tamtinh >= $voucher->dieukien) {
                $this->availableVouchers[] = $voucher->toArray();
            }
        }
    }

    /**
     * Áp dụng voucher từ mã nhập hoặc chọn từ danh sách
     */
    public function applyVoucher($code = null)
    {
        $codeToApply = strtoupper($code ?? trim($this->voucherCode));

        if (empty($codeToApply)) {
             session()->flash('voucher_error', 'Vui lòng nhập mã giảm giá.');
             return;
        }
        
        // 1. Tìm kiếm Voucher
        $voucher = MagiamgiaModel::where('magiamgia', $codeToApply)->first();

        if (!$voucher) {
            session()->flash('voucher_error', 'Mã giảm giá không tồn tại.');
            return;
        }

        // 2. Kiểm tra Điều kiện áp dụng
        if (!$this->checkVoucherConditions($voucher)) {
            // Flash message đã được xử lý trong checkVoucherConditions
            return;
        }

        // 3. Áp dụng Voucher (Lưu vào Session/DB)
        $this->appliedVoucher = $voucher->toArray();
        $this->voucherCode = $voucher->magiamgia;

        $voucherData = [
            'id' => $voucher->id,
            'magiamgia' => $voucher->magiamgia,
            'dieukien' => $voucher->dieukien,
            'giatri' => $voucher->giatri,
        ];

        // Lưu vào Session để duy trì trạng thái khi refresh
        Session::put('applied_voucher', $voucherData);
        
        // 4. Tính toán lại Tổng giá trị
        $this->tonggiatri();
        
        // 5. Cập nhật danh sách voucher có sẵn (để voucher vừa áp dụng không bị hiện ở mục 'Chọn')
        $this->loadAvailableVouchers(); 

        session()->flash('voucher_success', 'Đã áp dụng mã giảm giá **' . $codeToApply . '** thành công.');
    }

    /**
     * Hủy bỏ voucher đã áp dụng
     */
    public function removeVoucher()
    {
        $this->removeAppliedVoucher(true); // Gửi thông báo
    }

    private function removeAppliedVoucher(bool $flashMessage)
    {
        $this->appliedVoucher = null;
        $this->voucherCode = '';
        $this->giamgiaVoucher = 0;
        
        // Xóa khỏi Session
        Session::forget('applied_voucher');

        $this->tonggiatri();
        $this->loadAvailableVouchers();

        if ($flashMessage) {
            session()->flash('voucher_info', 'Đã hủy bỏ mã giảm giá.');
        }
    }


    public function render()
    {
        return view('client.livewire.giohangComponent');
    }
}