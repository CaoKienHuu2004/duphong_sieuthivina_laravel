<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GiohangModel extends Model
{
    use HasFactory;

    protected $table = 'giohang';
    protected $primaryKey = 'id';
    protected $fillable = [
        'id_bienthe',
        'id_nguoidung',
        'soluong',
        'thanhtien',
        'trangthai',
    ];
    public $timestamps = false;

    // ===========================================================================================================================
    // CÁC MỐI QUAN HỆ (RELATIONSHIPS)
    // ===========================================================================================================================
    public function nguoidung()
    {
        return $this->belongsTo(NguoidungModel::class, 'id_nguoidung', 'id');
    }
    public function bienthe()
    {
        return $this->belongsTo(BientheModel::class, 'id_bienthe', 'id');
    }
}
