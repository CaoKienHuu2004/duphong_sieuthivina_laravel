<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class NguoidungResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'username' => $this->username,
            'hoten' => $this->hoten,
            'email' => $this->email,
            'sodienthoai' => $this->sodienthoai,
            'gioitinh' => $this->gioitinh,
            'ngaysinh' => $this->ngaysinh,
            'vaitro' => $this->vaitro,
            'trangthai' => $this->trangthai,
            'avatar' => $this->avatar 
                ? asset('assets/client/images/thumbs/' . $this->avatar) 
                : asset('assets/client/images/default-avatar.png'),
            
            // Lấy danh sách địa chỉ từ bảng liên kết (nếu bạn đã định nghĩa relation trong Model)
            'danh_sach_diachi' => $this->diachi ?? [], 
        ];
    }
}