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
        'id_sanpham',
        'id_nguoidung',
        'id_chitietdonhang',
        'diem',
        'noidung',
        'trangthai',
    ];
    public $timestamps = false;
    protected $casts = [
        'id_sanpham' => 'integer',
        'id_nguoidung' => 'integer',
        'id_chitietdonhang' => 'integer',
        'diem' => 'integer',
    ];
    protected $attributes = [
        'trangthai' => 'Hiển thị',
    ];

    // ===========================================================================================================================
    // CÁC MỐI QUAN HỆ (RELATIONSHIPS)
    // ===========================================================================================================================
    public function sanpham()
    {
        return $this->belongsTo(SanphamModel::class, 'id_sanpham', 'id');
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
