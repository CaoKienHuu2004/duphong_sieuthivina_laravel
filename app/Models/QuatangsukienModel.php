<?php

namespace App\Models;

use Illuminate\Contracts\Database\Eloquent\CastsAttributes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class QuatangsukienModel extends Model
{
    use HasFactory,SoftDeletes;

    protected $table = 'quatang_sukien';
    protected $primaryKey = 'id';
    protected $fillable = [
        'id_bienthe',
        'id_chuongtrinh',
        'dieukiensoluong',
        'dieukiengiatri',
        'tieude',
        'thongtin',
        'hinhanh',
        'luotxem',
        'ngaybatdau',
        'ngayketthuc',
        'trangthai',
    ];
    public $timestamps = false;

    // ===========================================================================================================================
    // CÁC MỐI QUAN HỆ (RELATIONSHIPS)
    // ===========================================================================================================================
    // public function bienthe()
    // {
    //     return $this->belongsTo(BientheModel::class, 'id_bienthe');
    // }
    public function chuongtrinh()
    {
        return $this->belongsTo(ChuongtrinhModel::class, 'id_chuongtrinh');
    }

    public function sanphamthamgia()
    {
        return $this->belongsToMany(BientheModel::class, 'sanphamthamgia_quatang', 'id_quatang', 'id_bienthe');
    }

    public function sanphamduoctang()
    {
        return $this->belongsToMany(BientheModel::class, 'sanphamduoctang_quatang', 'id_quatang', 'id_bienthe')->withPivot('soluongtang');;
    }
}
