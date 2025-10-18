<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class YeuthichModel extends Model
{
    use SoftDeletes;

    protected $table = 'yeuthich';
    protected $primaryKey = 'id';
    protected $fillable = [
        'id_nguoidung',
        'id_sanpham',
        'trangthai',
    ];
    public $timestamps = false;

    // ===========================================================================================================================
    // CÁC MỐI QUAN HỆ (RELATIONSHIPS)
    // ===========================================================================================================================
    public function nguoidung()
    {
        return $this->belongsTo(NguoidungModel::class, 'id_nguoidung');
    }
    public function sanpham()
    {
        return $this->belongsTo(SanphamModel::class, 'id_sanpham');
    }

    // Scope: chỉ lấy sản phẩm yêu thích đang hiển thị
    public function scopeHienThi($query)
    {
        return $query->where('trangthai', 'Hiển thị');
    }

    // Scope: lấy các sản phẩm yêu thích đang tạm ẩn
    public function scopeTamAn($query)
    {
        return $query->where('trangthai', 'Tạm ẩn');
    }


}
