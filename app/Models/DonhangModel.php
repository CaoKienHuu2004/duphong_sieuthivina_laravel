<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class DonhangModel extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'donhang';
    protected $primaryKey = 'id';
    protected $fillable = [
        'id_nguoidung',
        'id_phuongthuc',
        'id_magiamgia',
        'id_diachinguoidung',
        'madon',
        'tongsoluong',
        'thanhtien',
        'trangthai',
    ];
    public $timestamps = true;

    // ===========================================================================================================================
    // CÁC MỐI QUAN HỆ (RELATIONSHIPS)
    // ===========================================================================================================================
    public function nguoidung()
    {
        return $this->belongsTo(NguoidungModel::class, 'id_nguoidung', 'id');
    }
    public function phuongthuc()
    {
        return $this->belongsTo(PhuongthucModel::class, 'id_phuongthuc', 'id');
    }
    public function magiamgia()
    {
        return $this->belongsTo(MagiamgiaModel::class, 'id_magiamgia', 'id');
    }
    public function diachinguoidung()
    {
        return $this->belongsTo(DiachinguoidungModel::class, 'id_diachinguoidung', 'id');
    }
    public function chitietdonhang()
    {
        return $this->hasMany(ChitietdonhangModel::class, 'id_donhang', 'id');
    }
}
