<?php

namespace App\Livewire;

use Livewire\Component;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use App\Models\MagiamgiaModel;
use App\Models\GiohangModel; 
use App\Models\BientheModel;
use App\Models\QuatangsukienModel; 
use App\Models\SanphamthamgiaquatangModel; 
use App\Models\SanphamduoctangquatangModel; 

class GiohangComponent extends Component
{
    public $giohang = []; 
    public $tamtinh = 0; 
    public $tonggiatri = 0;
    public $tietkiem = 0;
    public $quatang = [];
    public $tongsoquatang = 0;
    public $voucherCode = ''; 
    public $appliedVoucher = null; 
    public $giamgiaVoucher = 0; 
    public $availableVouchers = []; 

    public function mount()
    {
        // 1. Tải dữ liệu ban đầu
        $this->loadgiohang();
        
        // 2. Reset quà tặng để tính toán lại từ đầu (tránh cộng dồn sai)
        $this->xoaTatCaQuatang(); 
        
        // 3. Tính toán và thêm quà tặng mới
        $this->xacnhandieukienquatang(); 
        
        // 4. Tính toán tiền nong
        $this->tonggiatri();
        
        // 5. Tải và áp dụng lại Voucher (nếu có trong session)
        $this->loadAppliedVoucher(); 
        $this->tonggiatri(); // Tính lại lần cuối sau khi có voucher

        // 6. Lấy danh sách voucher khả dụng
        $this->loadAvailableVouchers();
    }

    /**
     * Tải giỏ hàng từ Database (Auth) hoặc Session (Guest)
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
            ->where('trangthai', 'Hiển thị') // FIX: Phải đúng chính tả như trong SQL
            ->get();

            $this->giohang = $giohangdb->toArray();

        } else {
            $giohangsession = Session::get('cart', []);
            
            foreach ($giohangsession as $cartKey => $item) { 
                // Tách ID thật từ key (ví dụ: '101_GIFT_0D' -> 101)
                $id_bienthe_actual = (int)str_replace('_GIFT_0D', '', $cartKey); 

                if (($item['soluong'] ?? 0) > 0) { 
                    $bienthe = BientheModel::with([
                        'sanpham.thuonghieu',
                        'sanpham.hinhanhsanpham', 
                        'loaibienthe'
                    ])->find($id_bienthe_actual); 

                    if ($bienthe) {
                        // Xác định giá bán: Nếu là quà (thanhtien=0) thì giá là 0, ngược lại lấy giá giảm/gốc
                        $isGift = ($item['thanhtien'] ?? 1) == 0;
                        $giaban = $isGift ? 0 : ($bienthe->giadagiam ?? $bienthe->giagoc);
                        
                        $this->giohang[] = [
                            'id_bienthe' => $id_bienthe_actual, 
                            'soluong' => $item['soluong'],
                            'thanhtien' => $item['thanhtien'] ?? ($item['soluong'] * $giaban), 
                            'bienthe' => $bienthe->toArray(),
                        ];
                    }
                }
            }
        }
        
        // Tách riêng mảng quà tặng để dễ hiển thị ở View
        $this->quatang = array_filter($this->giohang, fn($item) => $item['thanhtien'] == 0);
    }

    /**
     * Xóa sạch các món quà hiện có trong giỏ hàng để chuẩn bị tính toán lại
     */
    private function xoaTatCaQuatang()
    {
        if (Auth::check()) {
            GiohangModel::where('id_nguoidung', Auth::id())
                ->where('thanhtien', 0) // Quà tặng có thành tiền = 0
                ->delete();
        } else {
            $sessionCart = Session::get('cart', []);
            $newCart = [];
            
            foreach ($sessionCart as $key => $item) {
                // Giữ lại những món có thành tiền khác 0 (hàng mua)
                if (($item['thanhtien'] ?? 1) != 0) {
                    $newCart[$key] = $item;
                }
            }
            Session::put('cart', $newCart);
        }

        // Tải lại giỏ hàng (lúc này chỉ còn hàng khách mua)
        $this->loadgiohang();
    }
    
    /**
     * LOGIC CỐT LÕI: Xác định quà tặng dựa trên điều kiện Mua X Tặng Y
     */
    private function xacnhandieukienquatang()
    {
        $cartTotalValue = 0; 
        
        // 1. Tính tổng giá trị đơn hàng (chỉ tính hàng mua)
        foreach ($this->giohang as $item) {
            if ($item['thanhtien'] > 0) { 
                $cartTotalValue += $item['thanhtien'];
            }
        }

        // Lấy các chương trình quà tặng đang chạy
        $quatangsukiendb = QuatangsukienModel::where('trangthai', 'Hiển thị')
            ->whereNull('deleted_at')
            ->where(function($q) {
                $q->where('ngaybatdau', '<=', now())
                  ->where('ngayketthuc', '>=', now());
            })
            ->get();
        
        $themquatang = []; // Mảng chứa: [id_bienthe_quatang => so_luong_can_them]
        
        foreach ($quatangsukiendb as $rule) {
            // Điều kiện 1: Tổng giá trị đơn hàng tối thiểu
            if ($cartTotalValue < ($rule->dieukiengiatri ?? 0)) {
                continue;
            }

            $dieukienSoluong = (int)$rule->dieukiensoluong;
            if ($dieukienSoluong <= 0) continue; 

            // --- A. KIỂM TRA ĐIỀU KIỆN SẢN PHẨM MUA ---
            // Lấy danh sách sản phẩm KHÁCH PHẢI MUA để được quà
            $sanphamThamGiaIds = SanphamthamgiaquatangModel::where('id_quatang', $rule->id)
                                    ->pluck('id_bienthe')
                                    ->toArray();

            $soSuatQuaTang = 0; 

            if (count($sanphamThamGiaIds) > 0) {
                // Đếm tổng số lượng hàng khách đã mua nằm trong danh sách tham gia
                $matchingQuantity = 0;

                foreach ($this->giohang as $item) {
                    // Chỉ tính hàng mua (thanhtien > 0)
                    if ($item['thanhtien'] > 0 && in_array($item['id_bienthe'], $sanphamThamGiaIds)) {
                        $matchingQuantity += $item['soluong'];
                    }
                }

                // CÔNG THỨC: Số suất = Floor(Tổng mua / Điều kiện)
                $soSuatQuaTang = floor($matchingQuantity / $dieukienSoluong);

            } else {
                // Nếu chương trình không yêu cầu mua sp cụ thể (chỉ cần đạt giá trị đơn hàng)
                // Logic này tùy thuộc vào yêu cầu của bạn, ở đây tôi tạm set là 0 nếu không cấu hình sp tham gia
                // Nếu muốn áp dụng cho toàn bộ đơn hàng: $soSuatQuaTang = 1; (nếu đạt giá trị)
                $soSuatQuaTang = 1; 
            }

            // --- B. LẤY QUÀ TẶNG TỪ BẢNG 'SANPHAMDUOCTANG_QUATANG' ---
            if ($soSuatQuaTang > 0) {
                $danhSachQuaTang = SanphamduoctangquatangModel::where('id_quatang', $rule->id)->get();

                foreach ($danhSachQuaTang as $qua) {
                    $id_bienthe_gift = $qua->id_bienthe;
                    
                    // FIX: Trong SQL cột là 'soluongtang', không phải 'soluong'
                    $soluong_gift_config = $qua->soluongtang; 

                    // Tổng quà khách nhận
                    $tongSoluongGift = $soluong_gift_config * $soSuatQuaTang;

                    // Kiểm tra tồn kho thực tế của quà tặng (BientheModel)
                    $bientheQuatang = BientheModel::find($id_bienthe_gift);
                    if ($bientheQuatang && $bientheQuatang->soluong >= $tongSoluongGift) {
                        if (!isset($themquatang[$id_bienthe_gift])) {
                            $themquatang[$id_bienthe_gift] = 0;
                        }
                        // Lấy max để ưu tiên chương trình tặng nhiều hơn nếu trùng
                        $themquatang[$id_bienthe_gift] = max($themquatang[$id_bienthe_gift], $tongSoluongGift);
                    }
                }
            }
        }
        
        // Thực hiện thêm các món quà đã tính toán vào giỏ
        foreach ($themquatang as $id_bienthe => $soluong) {
            if ($soluong > 0) {
                $this->addGiftToCart($id_bienthe, $soluong); 
            }
        }

        $this->loadgiohang(); // Tải lại giỏ hàng để hiển thị ra View
    }

    /**
     * Thêm một món quà vào giỏ hàng (DB hoặc Session)
     */
    private function addGiftToCart(int $bientheId, int $soluong)
    {
        // 1. Kiểm tra xem món quà này ĐÃ TỒN TẠI trong giỏ hiện tại chưa (tránh loop)
        // Lưu ý: xoaTatCaQuatang đã chạy trước đó, nhưng kiểm tra lại cho chắc chắn
        foreach ($this->giohang as $item) {
            if ($item['id_bienthe'] == $bientheId && $item['thanhtien'] == 0) {
                return; // Đã có rồi thì thôi
            }
        }
        
        if (Auth::check()) {
            GiohangModel::updateOrCreate(
                [
                    'id_nguoidung' => Auth::id(),
                    'id_bienthe' => $bientheId,
                    'thanhtien' => 0, // Đánh dấu là quà tặng
                ],
                [
                    'soluong' => $soluong, 
                    'trangthai' => 'Hiển thị', // FIX: Đúng enum SQL
                ]
            );

        } else {
            $sessionCart = Session::get('cart', []);
            // Tạo key đặc biệt để không trùng với sản phẩm mua
            $giftKey = $bientheId . '_GIFT_0D'; 

            $sessionCart[$giftKey] = [
                'soluong' => $soluong,
                'thanhtien' => 0, 
            ];
            
            Session::put('cart', $sessionCart);
        }
    }

    /**
     * Tính toán tổng giá trị giỏ hàng, áp dụng voucher
     */
    public function tonggiatri()
    {
        $this->tamtinh = collect($this->giohang)->sum('thanhtien'); 
        
        $tongsanphamluutru = 0;
        $this->tongsoquatang = 0;
        
        foreach ($this->giohang as $item) {
            if ($item['thanhtien'] == 0) {
                // Xử lý quà tặng
                $this->tongsoquatang += $item['soluong'];
                $giaGocQuatang = $item['bienthe']['giagoc'] ?? 0;
                $tongsanphamluutru += $giaGocQuatang * $item['soluong'];
            } else {
                // Xử lý hàng mua (tính tiền tiết kiệm)
                $giaGoc = $item['bienthe']['giagoc'] ?? 0;
                $giaDaGiam = $item['bienthe']['giadagiam'] ?? $giaGoc;
                $giatritietkiem = max(0, $giaGoc - $giaDaGiam);
                $tongsanphamluutru += $giatritietkiem * $item['soluong'];
            }
        }
        
        $this->tietkiem = $tongsanphamluutru;
        $this->tonggiatri = $this->tamtinh; 

        $this->giamgiaVoucher = 0;

        // Tính giảm giá Voucher
        if ($this->appliedVoucher) {
            $voucher = (object)$this->appliedVoucher; 
            
            // Check lại điều kiện tối thiểu
            if ($this->tamtinh >= $voucher->dieukien) {
                $giamgia = (float) $voucher->giatri;
                $this->giamgiaVoucher = min($giamgia, $this->tamtinh);
            } else {
                // Nếu không đủ điều kiện nữa thì hủy voucher
                $this->removeAppliedVoucher(true);
            }
        }

        $this->tonggiatri = $this->tamtinh - $this->giamgiaVoucher;
        $this->tietkiem += $this->giamgiaVoucher;

        $this->loadAvailableVouchers();
    }

    /**
     * Cập nhật số lượng sản phẩm trong giỏ
     */
    public function capnhatsoluong($bientheId, $soluong)
    {
        $soluong = max(1, (int)$soluong);

        foreach ($this->giohang as $index => $item) {
            if ($item['id_bienthe'] == $bientheId) {
                // Không cho sửa số lượng quà tặng
                if ($item['thanhtien'] == 0) {
                    session()->flash('error_message', "Không thể chỉnh sửa số lượng quà tặng.");
                    return; 
                }

                $soluonghientai = $this->giohang[$index]['soluong'];
                $giaban = $item['bienthe']['giadagiam'] ?? $item['bienthe']['giagoc'] ?? 0;

                // Check tồn kho
                $tonkho = $item['bienthe']['soluong'] ?? 0;
                if ($soluong > $tonkho) {
                    session()->flash('error_message', "Xin lỗi, số lượng tồn kho chỉ còn $tonkho sản phẩm.");
                    return; 
                }

                if ($soluonghientai != $soluong) {
                    $thanhtien_moi = $soluong * $giaban;
                    
                    // Cập nhật mảng local
                    $this->giohang[$index]['soluong'] = $soluong;
                    $this->giohang[$index]['thanhtien'] = $thanhtien_moi;
                                                    
                    // Cập nhật DB/Session
                    $this->capnhatgiohang($bientheId, $soluong, $thanhtien_moi); 
                    
                    // QUAN TRỌNG: Tính toán lại quà tặng sau khi đổi số lượng
                    $this->xoaTatCaQuatang(); 
                    $this->xacnhandieukienquatang(); 
                    
                    $this->tonggiatri();

                    session()->flash('update_message', 'Đã cập nhật số lượng sản phẩm.');
                }
                return;
            }
        }
    }

    /**
     * Helper cập nhật DB hoặc Session
     */
    private function capnhatgiohang(int $bientheId, int $soluong, float $thanhtien)
    {
        if (Auth::check()) {
            $cartItems = GiohangModel::where('id_nguoidung', Auth::id())
                ->where('id_bienthe', $bientheId)
                ->where('thanhtien', '>', 0) // Chỉ cập nhật hàng mua
                ->get();

            if ($cartItems->isEmpty()) return;

            $firstItem = $cartItems->first();
            $firstItem->update([
                'soluong' => $soluong,
                'thanhtien' => $thanhtien,
            ]);

            // Xóa bớt dòng trùng lặp nếu có lỗi data cũ
            if ($cartItems->count() > 1) {
                $idsToDelete = $cartItems->except($firstItem->id)->pluck('id');
                GiohangModel::destroy($idsToDelete);
            }

        } else {
            $sessionCart = Session::get('cart', []);
            if (isset($sessionCart[$bientheId])) {
                $sessionCart[$bientheId]['soluong'] = $soluong;
                $sessionCart[$bientheId]['thanhtien'] = $thanhtien;
                Session::put('cart', $sessionCart);
            }
        }
    }

    /**
     * Xóa sản phẩm khỏi giỏ hàng
     */
    public function xoagiohang($bientheId)
    {
        if (Auth::check()) {
            GiohangModel::where('id_nguoidung', Auth::id())
                ->where('id_bienthe', $bientheId)
                ->delete();

        } else {
            $sessionCart = Session::get('cart', []);
            
            $purchasedKey = (string)$bientheId;
            $giftKey = $bientheId . '_GIFT_0D';

            unset($sessionCart[$purchasedKey]);
            unset($sessionCart[$giftKey]); // Xóa luôn quà đi kèm nếu có key này
            
            Session::put('cart', $sessionCart);
        }
        
        // Cập nhật lại mảng hiển thị
        $this->giohang = array_filter($this->giohang, function ($item) use ($bientheId) {
            return $item['id_bienthe'] != $bientheId;
        });
        
        // Tính toán lại quà tặng (vì nếu xóa sp mua thì quà có thể mất)
        $this->xoaTatCaQuatang(); 
        $this->xacnhandieukienquatang(); 

        $this->tonggiatri();
        session()->flash('update_message', 'Đã xóa sản phẩm khỏi giỏ hàng.');
    }

    // --- CÁC HÀM VOUCHER ---

    private function loadAppliedVoucher()
    {
        $voucherData = Session::get('applied_voucher', null); 

        if ($voucherData) {
            $voucher = MagiamgiaModel::where('magiamgia', $voucherData['magiamgia'])->first();

            if ($voucher && $this->checkVoucherConditions($voucher, false)) { 
                $this->appliedVoucher = $voucher->toArray(); 
                $this->voucherCode = $voucher->magiamgia;
            } else {
                $this->removeAppliedVoucher(false);
            }
        }
    }

    private function checkVoucherConditions($voucher, $flashMessage = true)
    {
        if (!$voucher || $voucher->trangthai !== 'Hoạt động') {
             if ($flashMessage) session()->flash('voucher_error', 'Mã giảm giá không hợp lệ hoặc không hoạt động.');
            return false;
        }

        if ($voucher->ngayketthuc && now()->gt($voucher->ngayketthuc)) {
             if ($flashMessage) session()->flash('voucher_error', 'Mã giảm giá đã hết hạn sử dụng.');
            return false;
        }

        if ($this->tamtinh < $voucher->dieukien) {
            if ($flashMessage) session()->flash('voucher_error', 'Giỏ hàng chưa đủ điều kiện (Giá trị tối thiểu: ' . number_format($voucher->dieukien,0,',','.') . ' ₫).');
            return false;
        }

        return true;
    }

    public function loadAvailableVouchers()
    {
        $allVouchers = MagiamgiaModel::where('trangthai', 'Hoạt động')
            ->where(function ($query) {
                $query->whereNull('ngayketthuc')
                      ->orWhere('ngayketthuc', '>=', now());
            })
            ->get();
            
        $this->availableVouchers = [];
        
        foreach ($allVouchers as $voucher) {
            if ($this->tamtinh >= $voucher->dieukien) {
                $this->availableVouchers[] = $voucher->toArray();
            }
        }
    }

    public function applyVoucher($code = null)
    {
        $codeToApply = strtoupper($code ?? trim($this->voucherCode));

        if (empty($codeToApply)) {
             session()->flash('voucher_error', 'Vui lòng nhập mã giảm giá.');
             return;
        }
        
        $voucher = MagiamgiaModel::where('magiamgia', $codeToApply)->first();

        if (!$voucher) {
            session()->flash('voucher_error', 'Mã giảm giá không tồn tại.');
            return;
        }

        if (!$this->checkVoucherConditions($voucher)) {
            return;
        }

        $this->appliedVoucher = $voucher->toArray();
        $this->voucherCode = $voucher->magiamgia;

        $voucherData = [
            'id' => $voucher->id,
            'magiamgia' => $voucher->magiamgia,
            'dieukien' => $voucher->dieukien,
            'giatri' => $voucher->giatri,
        ];

        Session::put('applied_voucher', $voucherData);
        
        $this->tonggiatri();
        $this->loadAvailableVouchers(); 

        session()->flash('voucher_success', 'Đã áp dụng mã giảm giá **' . $codeToApply . '** thành công.');
    }

    public function removeVoucher()
    {
        $this->removeAppliedVoucher(true); 
    }

    private function removeAppliedVoucher(bool $flashMessage)
    {
        $this->appliedVoucher = null;
        $this->voucherCode = '';
        $this->giamgiaVoucher = 0;
        
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