<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class SanphamModel extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'sanpham';
    protected $primaryKey = 'id';
    protected $fillable = [
        'id_thuonghieu',
        'ten',
        'slug',
        'mota',
        'xuatxu',
        'sanxuat',
        'trangthai',
        'giamgia',
        'luotxem',
    ];
    public $timestamps = false;

    // ===========================================================================================================================
    // CÁC MỐI QUAN HỆ (RELATIONSHIPS)
    // ===========================================================================================================================
    public function danhmuc(): BelongsToMany
    {
        return $this->belongsToMany(DanhmucModel::class, 'danhmuc_sanpham', 'id_sanpham', 'id_danhmuc');
    }
    public function bienthe(): HasMany
    {
        return $this->hasMany(BientheModel::class, 'id_sanpham');
    }
    public function thuonghieu(): BelongsTo
    {
        return $this->belongsTo(ThuonghieuModel::class, 'id_thuonghieu');
    }
    public function hinhanhsanpham(): HasMany
    {
        return $this->hasMany(HinhanhsanphamModel::class, 'id_sanpham');
    }

    public function chitietdonhang()
    {
        return $this->hasManyThrough(
            ChitietdonhangModel::class, // bảng cuối
            BientheModel::class,        // bảng trung gian
            'id_sanpham',          // khóa ngoại ở bảng BienThe trỏ tới SanPham
            'id_bienthe',          // khóa ngoại ở bảng ChiTietDonHang trỏ tới BienThe
            'id',                  // khóa chính ở SanPham
            'id'                   // khóa chính ở BienThe
        );
    }


}
