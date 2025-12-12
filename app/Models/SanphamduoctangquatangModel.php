<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SanphamduoctangQuatangModel extends Model
{
    use HasFactory;

    // 1. Khai báo tên bảng (vì tên bảng không theo chuẩn số nhiều tiếng Anh)
    protected $table = 'sanphamduoctang_quatang';

    // 2. Tắt timestamps (QUAN TRỌNG: vì bảng này trong SQL không có created_at/updated_at)
    public $timestamps = false;

    // 3. Khai báo các cột được phép thêm sửa (Mass Assignment)
    protected $fillable = [
        'id_bienthe',
        'id_quatang',
        'soluongtang',
    ];

    // --- CÁC MỐI QUAN HỆ (RELATIONSHIPS) ---

    /**
     * Liên kết ngược về bảng Biến thể sản phẩm
     */
    public function bienthe()
    {
        return $this->belongsTo(BientheModel::class, 'id_bienthe', 'id');
    }

    /**
     * Liên kết ngược về bảng Quà tặng sự kiện
     */
    public function quatang()
    {
        return $this->belongsTo(QuatangsukienModel::class, 'id_quatang', 'id');
    }
}