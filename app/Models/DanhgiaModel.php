<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DanhgiaModel extends Model
{
    use HasFactory;

    protected $table = 'danhgia';
    protected $primaryKey = 'id';
    protected $fillable = [
        'id_bienthe',
        'id_nguoidung',
        'id_chitietdonhang',
        'diem',
        'noidung',
        'trangthai',
    ];
    public $timestamps = false;

    // ===========================================================================================================================
    // CÁC MỐI QUAN HỆ (RELATIONSHIPS)
    // ===========================================================================================================================
    public function bienthe()
    {
        return $this->belongsTo(BientheModel::class, 'id_bienthe', 'id');
    }
    public function nguoidung()
    {
        return $this->belongsTo(NguoidungModel::class, 'id_nguoidung', 'id');
    }

    public function chitietdonhang()
    {
        return $this->belongsTo(ChitietdonhangModel::class, 'id_chitietdonhang', 'id');
    }
}
