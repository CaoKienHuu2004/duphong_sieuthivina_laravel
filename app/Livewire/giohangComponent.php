<?php

namespace App\Livewire;

use Livewire\Component;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
// Import Model Quà tặng của bạn
use App\Models\GiohangModel; 
use App\Models\BientheModel;
use App\Models\QuatangsukienModel; 

class giohangComponent extends Component
{
    public $giohang = []; 
    public $tamtinh = 0; 
    public $tonggiatri = 0;
    public $tietkiem = 0;
    public $quatang = [];
    public $tongsoquatang = 0; 

    public function mount()
    {
        $this->loadgiohang();
        // Bắt đầu bằng cách xóa hết quà tặng cũ để kiểm tra lại điều kiện
        $this->xoaTatCaQuatang(); 
        $this->xacnhandieukienquatang();
        $this->tonggiatri();
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
            $giohangsession = Session::get('cart', []);
            
            foreach ($giohangsession as $id_bienthe => $item) {
                if (($item['soluong'] ?? 0) > 0) { 
                    $bienthe = BientheModel::with([
                        'sanpham.thuonghieu',
                        'sanpham.hinhanhsanpham', 
                        'loaibienthe'
                    ])->find($id_bienthe);
                    
                    if ($bienthe) {
                        $isGift = ($item['thanhtien'] ?? 1) == 0;
                        $giaban = $isGift ? 0 : ($bienthe->giadagiam ?? $bienthe->giagoc);
                        
                        $this->giohang[] = [
                            'id_bienthe' => $id_bienthe,
                            'soluong' => $item['soluong'],
                            'thanhtien' => $item['thanhtien'] ?? ($item['soluong'] * $giaban), // Giữ lại thanhtien nếu có từ session, tránh tính toán lại quà tặng 0đ
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
            
            $bientheIdsToRemove = [];
            foreach ($sessionCart as $bientheId => $item) {
                if (($item['thanhtien'] ?? 1) == 0) {
                    $bientheIdsToRemove[] = $bientheId;
                }
            }
            
            foreach ($bientheIdsToRemove as $id) {
                unset($sessionCart[$id]);
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
            $sessionCart = Session::get('cart', []);
            
            // Dùng id_bienthe làm key, ghi đè nếu tồn tại
            $sessionCart[$bientheId] = [
                'soluong' => $soluong,
                'thanhtien' => 0,
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
            GiohangModel::where('id_nguoidung', Auth::id())
                ->where('id_bienthe', $bientheId)
                ->update([
                    'soluong' => $soluong,
                    'thanhtien' => $thanhtien,
                ]);

        } else {
            $sessionCart = Session::get('cart', []);
            
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
            $sessionCart = Session::get('cart', []);
            unset($sessionCart[$bientheId]);
            Session::put('cart', $sessionCart);
        }
        
        $this->giohang = array_filter($this->giohang, function ($item) use ($bientheId) {
            return $item['id_bienthe'] != $bientheId;
        });
        
        // BƯỚC QUAN TRỌNG: Kiểm tra lại quà tặng sau khi xóa sản phẩm chính
        $this->xoaTatCaQuatang(); // Xóa quà tặng cũ
        $this->xacnhandieukienquatang(); // Thêm quà tặng mới (nếu đủ điều kiện)

        $this->tonggiatri();
        session()->flash('update_message', 'Đã xóa sản phẩm khỏi giỏ hàng.');
    }

    public function render()
    {
        return view('client.livewire.giohangComponent');
    }
}
