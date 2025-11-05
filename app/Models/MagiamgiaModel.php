<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class MagiamgiaModel extends Model
{
    use HasFactory,SoftDeletes;

    protected $table = 'magiamgia';
    protected $primaryKey = 'id';
    protected $fillable = [
        'magiamgia',
        'dieukien',
        'mota',
        'giatri',
        'ngaybatdau',
        'ngayketthuc',
        'trangthai',
    ];
    public $timestamps = false;

    // ===========================================================================================================================
    // CÁC MỐI QUAN HỆ (RELATIONSHIPS)
    // ===========================================================================================================================
    public function donhang() : HasMany
    {
        return $this->hasMany(DonhangModel::class, 'id_magiamgia');
    }
}