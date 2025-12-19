<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class SanphamResource extends JsonResource
{
    public function toArray($request)
    {
        // 1. Lấy biến thể đầu tiên để lấy giá gốc (Bảng 'bienthe')
        // SQL của bạn: id, id_sanpham, tenbienthe, giagoc, soluong, luotban, trangthai
        $variant = $this->bienthe->sortBy('giagoc')->first(); 
        $giaGoc = $variant->giagoc ?? 0;
        
        // 2. Tính giá sau giảm (Cột 'giamgia' trong bảng 'sanpham')
        $phanTramGiam = $this->giamgia ?? 0;
        $giaDaGiam = $giaGoc * (1 - ($phanTramGiam / 100));

        return [
            'id' => $this->id,
            'tensanpham' => $this->ten, // Cột 'tensanpham'
            'slug' => $this->slug,           // Cột 'slug'
            'giamgia' => $phanTramGiam,       // Cột 'giamgia'
            'mota' => $this->mota,           // Cột 'mota'
            'luotxem' => $this->luotxem,     // Cột 'luotxem'
            'trangthai' => $this->trangthai, // Cột 'trangthai'

            // 3. Hình ảnh (Bảng 'hinhanh_sanpham')
            // SQL: id, id_sanpham, hinhanh
            'hinhanh' => $this->hinhanhsanpham->map(function($img) {
                return [
                    'id' => $img->id,
                    'url' => asset('assets/client/images/thumbs/' . $img->hinhanh)
                ];
            }),

            // 4. Thương hiệu (Bảng 'thuonghieu')
            // SQL: id, tenthuonghieu, hinhanh, trangthai
            'thuonghieu' => [
                'id' => $this->thuonghieu->id ?? null,
                'ten' => $this->thuonghieu->ten ?? null,
                'logo' => asset('assets/client/images/brands/' . $this->thuonghieu->logo ?? null),
            ],

            // 5. Danh mục (Bảng trung gian 'danhmuc_sanpham')
            // SQL kết nối: sanpham.id -> danhmuc_sanpham.id_sanpham | danhmuc_sanpham.id_danhmuc -> danhmuc.id
            'danhmuc' => $this->danhmuc->map(function($dm) {
                return [
                    'id' => $dm->id,
                    'ten' => $dm->ten,
                    'slug' => $dm->slug,
                    'logo' => asset('assets/client/images/categories/' . $dm->logo) ?? null,
                ];
            }),

            // 6. Thông tin giá thô và định dạng
            'gia' => [
                'giagoc' => (int)$giaGoc,
                'giadagiam' => (int)$giaDaGiam,
                'formatted_giagoc' => number_format($giaGoc, 0, ',', '.') . 'đ',
                'formatted_giadagiam' => number_format($giaDaGiam, 0, ',', '.') . 'đ',
            ],

            // 7. Thống kê lượt bán (Tính tổng từ các biến thể)
            'tong_luotban' => (int) ($this->bienthe_sum_luotban ?? 0),
        ];
    }
}