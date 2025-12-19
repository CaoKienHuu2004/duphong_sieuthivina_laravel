<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class SanphamResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        // 1. Lấy biến thể đầu tiên để lấy giá gốc đại diện
        // Lưu ý: Đảm bảo trong Controller đã eager load 'bienthe'
        $variant = $this->bienthe->first(); 
        
        $giaGoc = $variant ? $variant->giagoc : 0;
        
        // 2. Tính toán giá đã giảm dựa trên cột 'giamgia' (ví dụ: 10 nghĩa là giảm 10%)
        $phanTramGiam = $this->giamgia ?? 0;
        $giaDaGiam = $giaGoc * (1 - ($phanTramGiam / 100));

        return [
            'id' => $this->id,
            'ten_san_pham' => $this->ten, // Đã sửa từ 'ten' thành 'tensanpham'
            'slug' => $this->slug,
            
            // Trả về danh sách hình ảnh từ bảng hinhanh_sanpham
            'hinh_anh' => $this->hinhanhsanpham->map(function($img) {
                return [
                    'id' => $img->id,
                    'duong_dan' => $img->hinhanh // Tên cột ảnh trong bảng hinhanh_sanpham
                ];
            }),
            
            'phan_tram_giam' => $phanTramGiam . '%',
            
            'gia_hien_thi' => [
                'gia_goc' => $giaGoc,
                'gia_goc_format' => number_format($giaGoc, 0, ',', '.') . 'đ',
                'gia_da_giam' => $giaDaGiam,
                'gia_da_giam_format' => number_format($giaDaGiam, 0, ',', '.') . 'đ',
            ],
            
            // Lấy từ withSum('bienthe', 'luotban') trong Controller
            'tong_luot_ban' => (int) ($this->bienthe_sum_luotban ?? 0),
            
            // Thông tin thương hiệu (Cột tenthuonghieu trong bảng thuonghieu)
            'thuong_hieu' => $this->thuonghieu->ten ?? 'Không có thương hiệu',
            
            // Thông tin danh mục (Lấy tên danh mục đầu tiên nếu có)
            'danh_muc' => $this->danhmuc->first()->ten ?? null,
            
            'luot_xem' => $this->luotxem,
            'trang_thai' => $this->trangthai,
        ];
    }
}