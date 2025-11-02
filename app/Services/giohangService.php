<?php

namespace App\Services;
use Illuminate\Support\Facades\Redis;
use Illuminate\Support\Facades\Auth;
use App\Models\BientheModel;
use App\Models\MagiamgiaModel;
use App\Models\SanphamModel;

class giohangService
{
    protected $giohangKeyPrefix = 'giohang:';
    protected $magiamgiaKeyPrefix = 'magiamgia:';

    /**
     * Lấy key Redis cho giỏ hàng của người dùng hiện tại.
     */
    private function getGiohangKey()
    {
        return Auth::check() ? $this->giohangKeyPrefix . Auth::id() : null;
    }
    
    /**
     * Lấy key Redis cho voucher của người dùng hiện tại.
     */
    private function getMagiamgiaKey()
    {
        return Auth::check() ? $this->magiamgiaKeyPrefix . Auth::id() : null;
    }

    /**
     * Tính Đơn Giá Đã Giảm
     */
    private function tinhDonGiaDaGiam($giagoc, $phanTramGiam)
    {
        if ($phanTramGiam > 0 && $phanTramGiam <= 100) {
            return $giagoc - ($giagoc * $phanTramGiam / 100);
        }
        return $giagoc;
    }
    
    /**
     * Logic kiểm tra điều kiện voucher (Giả sử 'dieukien' là giá trị tối thiểu)
     */
    public function kiemTraDieuKienVoucher($voucher, $tongTamTinh)
    {
        $dieuKien = (float) $voucher->dieukien;
        return $tongTamTinh >= $dieuKien;
    }

    /**
     * Logic tính giá trị giảm của voucher
     */
    public function tinhGiaTriGiam($voucher, $tongTamTinh)
    {
        $giaTri = $voucher->giatri; // Có thể là '50000' hoặc '10%'
        
        if (str_contains($giaTri, '%')) {
            $phanTram = (float) str_replace('%', '', $giaTri);
            $giam = $tongTamTinh * $phanTram / 100;
        } else {
            $giam = (float) $giaTri; // Giả sử giá trị cố định
        }
        
        // Giả sử voucher không giảm quá tổng tiền
        return min($giam, $tongTamTinh);
    }
    
    /**
     * Lấy tất cả dữ liệu giỏ hàng, tính toán tổng tiền, voucher và tiền tiết kiệm.
     */
    public function getCartData()
    {
        $cartKey = $this->getGiohangKey();
        if (!$cartKey) {
            return $this->getDefaultCartData();
        }

        // 1. Lấy dữ liệu giỏ hàng và voucher từ Redis
        $cartItemsRedis = Redis::hgetall($cartKey) ?? [];
        $voucherCode = Redis::get($this->getMagiamgiaKey());

        $items = [];
        $tongTamTinh = 0;
        $tongTienTietKiemSanPham = 0;
        $giamGiaVoucher = 0;
        $voucherThongTin = null;
        
        // 2. Hydrate và tính toán chi tiết sản phẩm
        if (!empty($cartItemsRedis)) {
            $ids = array_keys($cartItemsRedis);
            
            // Eager Load tất cả mối quan hệ cần thiết
            $bienthes = BientheModel::with(['sanpham.thuonghieu', 'sanpham.hinhanhsanpham', 'loaibienthe'])
                ->whereIn('id', $ids)
                ->get()
                ->keyBy('id');

            foreach ($cartItemsRedis as $id_bienthe => $soluong) {
                $bienthe = $bienthes->get($id_bienthe);
                if (!$bienthe) {
                    // Xóa sản phẩm nếu không tìm thấy trong DB (bị xóa)
                    Redis::hdel($cartKey, $id_bienthe);
                    continue;
                }
                
                $soluong = (int) $soluong;
                $giaGoc = (float) $bienthe->giagoc;
                $phanTramGiamSP = (float) $bienthe->sanpham->giamgia ?? 0;

                // Tính Đơn Giá Đã Giảm và Thành Tiền
                $donGiaDaGiam = $this->tinhDonGiaDaGiam($giaGoc, $phanTramGiamSP);
                $thanhTien = $donGiaDaGiam * $soluong;
                
                // Tính tiền tiết kiệm riêng của sản phẩm
                $tienTietKiemSP = ($giaGoc - $donGiaDaGiam) * $soluong;

                $items[] = [
                    'id_bienthe'        => $bienthe->id,
                    'soluong'           => $soluong,
                    'gia_goc'           => $giaGoc,
                    'phan_tram_giam_sp' => $phanTramGiamSP,
                    'don_gia_da_giam'   => $donGiaDaGiam,
                    'thanh_tien'        => $thanhTien,
                    'tien_tiet_kiem_sp' => $tienTietKiemSP,
                    'ton_kho'           => $bienthe->soluong,
                    'sanpham' => [
                        'ten'         => $bienthe->sanpham->ten,
                        'thuong_hieu' => $bienthe->sanpham->thuonghieu->ten ?? 'N/A',
                        'anh_dai_dien'=> $bienthe->sanpham->hinhanhsanpham->first()->hinhanh,
                        'ten_bien_the'=> $bienthe->loaibienthe->ten ?? 'Mặc định',
                    ],
                ];

                $tongTamTinh += $thanhTien;
                $tongTienTietKiemSanPham += $tienTietKiemSP;
            }
        }

        // 3. Tính toán Voucher (Nếu có)
        if ($voucherCode) {
            $voucher = MagiamgiaModel::where('trangthai','Hoạt động')
                ->where('magiamgia', $voucherCode)
                ->whereDate('ngayketthuc', '>=', now())
                ->first();
            
            if ($voucher && $this->kiemTraDieuKienVoucher($voucher, $tongTamTinh)) {
                $giamGiaVoucher = $this->tinhGiaTriGiam($voucher, $tongTamTinh);
                $voucherThongTin = [
                    'ma' => $voucher->magiamgia,
                    'mo_ta' => $voucher->mota,
                    'gia_tri_giam' => $giamGiaVoucher,
                ];
            } else {
                // Nếu voucher không hợp lệ/hết hạn/không đủ điều kiện, xóa khỏi Redis
                Redis::del($this->getMagiamgiaKey());
                $voucherCode = null;
            }
        }
        
        $tongGiaTriDonHang = $tongTamTinh - $giamGiaVoucher;
        $tongTienTietKiem = $tongTienTietKiemSanPham + $giamGiaVoucher;

        return [
            'items'                 => $items,
            'tong_tam_tinh'         => max(0, $tongTamTinh),
            'giam_gia_voucher'      => max(0, $giamGiaVoucher),
            'tong_gia_tri_don_hang' => max(0, $tongGiaTriDonHang),
            'tong_tien_tiet_kiem'   => max(0, $tongTienTietKiem),
            'voucher'               => $voucherThongTin,
        ];
    }
    
    private function getDefaultCartData()
    {
        return [
            'items'                 => [],
            'tong_tam_tinh'         => 0,
            'giam_gia_voucher'      => 0,
            'tong_gia_tri_don_hang' => 0,
            'tong_tien_tiet_kiem'   => 0,
            'voucher'               => null,
        ];
    }

    // ========================================================================
    // CÁC HÀM TƯƠNG TÁC REDIS
    // ========================================================================

    public function themVaoGio($id_bienthe, $soluongThem)
    {
        $cartKey = $this->getGiohangKey();
        if (!$cartKey) return false;
        
        $bienthe = BientheModel::find($id_bienthe);
        if (!$bienthe) return false; // Biến thể không tồn tại

        $soluongHienTai = (int) Redis::hget($cartKey, $id_bienthe);
        $soluongMoi = $soluongHienTai + $soluongThem;

        if ($bienthe->soluong < $soluongMoi) {
            return false; // Hết hàng
        }

        Redis::hincrby($cartKey, $id_bienthe, $soluongThem);
        Redis::expire($cartKey, 60 * 60 * 24 * 30); // 30 ngày
        return true;
    }

    public function capNhatSoLuong($id_bienthe, $soluongMoi)
    {
        $cartKey = $this->getGiohangKey();
        if (!$cartKey) return false;
        
        $bienthe = BientheModel::find($id_bienthe);
        if (!$bienthe) return false;

        if ($bienthe->soluong < $soluongMoi) {
            return false; // Hết hàng
        }
        
        Redis::hset($cartKey, $id_bienthe, $soluongMoi);
        return true;
    }

    public function xoaSanPham($id_bienthe)
    {
        $cartKey = $this->getGiohangKey();
        if (!$cartKey) return false;
        
        Redis::hdel($cartKey, $id_bienthe);
        return true;
    }

    public function apDungVoucher($code)
    {
        $voucherKey = $this->getMagiamgiaKey();
        if (!$voucherKey) return ['status' => 'error', 'message' => 'Yêu cầu đăng nhập.'];
        
        // 1. Kiểm tra trong Database
        $voucher = MagiamgiaModel::where('trangthai','Hoạt động')
            ->where('magiamgia', $code)
            ->whereDate('ngayketthuc', '>=', now())
            ->first();

        if (!$voucher) {
            return ['status' => 'error', 'message' => 'Mã giảm giá không hợp lệ hoặc đã hết hạn.'];
        }

        // 2. Lấy tổng tạm tính hiện tại của giỏ hàng để kiểm tra điều kiện
        $currentCartData = $this->getCartData();
        $tongTamTinh = $currentCartData['tong_tam_tinh'];
        
        if (!$this->kiemTraDieuKienVoucher($voucher, $tongTamTinh)) {
            $dieuKienToiThieu = (float) $voucher->dieukien;
            return [
                'status' => 'error', 
                'message' => 'Giỏ hàng chưa đạt giá trị tối thiểu: ' . number_format($dieuKienToiThieu) . 'đ.'
            ];
        }

        // 3. Nếu Hợp lệ và Đủ điều kiện, lưu mã vào Redis
        Redis::set($voucherKey, $code);
        Redis::expire($voucherKey, 60 * 60 * 24 * 1); // 1 ngày

        return ['status' => 'success', 'message' => 'Áp dụng mã giảm giá thành công!'];
    }

    public function xoaVoucher()
    {
        $voucherKey = $this->getMagiamgiaKey();
        if (!$voucherKey) return false;
        
        Redis::del($voucherKey);
        return true;
    }
}