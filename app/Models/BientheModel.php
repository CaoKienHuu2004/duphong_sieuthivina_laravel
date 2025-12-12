<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;
class BientheModel extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'bienthe';
    protected $primaryKey = 'id';
    protected $fillable = [
        'id_loaibienthe',
        'id_sanpham',
        'giagoc',
        'soluong',
        'luottang',
        'luotban',
        'trangthai',
    ];
    protected $appends = ['giadagiam'];
    public $timestamps = false;

    // ===========================================================================================================================
    // CÁC MỐI QUAN HỆ (RELATIONSHIPS)
    // ===========================================================================================================================
    public function sanpham(): BelongsTo
    {
        return $this->belongsTo(SanphamModel::class, 'id_sanpham','id');
    }

    public function loaibienthe(): BelongsTo
    {
        return $this->belongsTo(LoaibientheModel::class, 'id_loaibienthe','id');
    }

    // public function quatangsukien()
    // {
    //     return $this->hasOne(QuatangsukienModel::class, 'id_bienthe', 'id');
    // }

    // ===========================================================================================================================
    // BỘ TRUY CẬP (ACCESSORS)
    // ===========================================================================================================================
    public function getGiadagiamAttribute()
    {
        $giagoc = $this->giagoc;

        $giamgia_phantram = $this->sanpham->giamgia ?? 0;

        $giadagiam = $giagoc - ($giagoc * $giamgia_phantram / 100);
        return $giadagiam; 
    }

    public function sanphamthamgia()
    {
         return $this->belongsToMany(QuatangsukienModel::class, 'sanphamthamgia_quatang', 'id_bienthe', 'id_quatang');
    }

    public function sanphamduoctang()
    {
         return $this->belongsToMany(QuatangsukienModel::class, 'sanphamduoctang_quatang', 'id_bienthe', 'id_quatang');
    }
}
