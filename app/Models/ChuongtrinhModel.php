<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ChuongtrinhModel extends Model
{
    use HasFactory,SoftDeletes;

    protected $table = 'chuongtrinh';
    protected $primaryKey = 'id';
    protected $fillable = [
        'tieude',
        'slug',
        'hinhanh',
        'noidung',
        'trangthai',
    ];
    public $timestamps = false;
    
    // ===========================================================================================================================
    // CÁC MỐI QUAN HỆ (RELATIONSHIPS)
    // ===========================================================================================================================
    public function quatang()
    {
        return $this->hasMany(QuatangsukienModel::class, 'id_chuongtrinh','id');
    }

    
    public function scopeHienThi($query)
    {
        return $query->where('trangthai', 'Hiển thị');
    }
    public function scopeTamAn($query)
    {
        return $query->where('trangthai', 'Tạm ẩn');
    }
    public function scopeDangDienRa($query)
    {
        $today = now()->toDateString();
        return $query->where('ngaybatdau', '<=', $today)
                     ->where('ngayketthuc', '>=', $today);
    }
}
