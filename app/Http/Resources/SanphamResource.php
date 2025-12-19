<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class SanphamResource extends JsonResource
{
    public function toArray($request)
    {
        // Lấy biến thể đầu tiên/rẻ nhất để làm giá đại diện
        $variant = $this->bienthe->first(); 
        $giaGoc = $variant->giagoc ?? 0;
        $giaDaGiam = $giaGoc * (1 - ($this->giamgia / 100));

        return [
            'id' => $this->id,
            'ten_san_pham' => $this->tensanpham,
            'slug' => $this->slug,
            'hinh_anh' => $this->hinhanhsanpham, // Trả về array ảnh
            'giam_gia' => $this->giamgia . '%',
            'gia_hien_thi' => [
                'gia_goc' => number_format($giaGoc, 0, ',', '.'),
                'gia_da_giam' => number_format($giaDaGiam, 0, ',', '.'),
                'raw_gia_da_giam' => $giaDaGiam
            ],
            'luot_ban' => $this->bienthe_sum_luotban ?? 0,
            'thuong_hieu' => $this->thuonghieu->tenthuonghieu ?? null,
        ];
    }
}
