<?php

namespace App\Models;

use App\Http\Controllers\admin\QuatangsukienController;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class ThuonghieuModel extends Model
{
    use HasFactory;

    protected $table = 'thuonghieu';
    protected $primaryKey = 'id';
    protected $fillable = [
        'ten',
        'slug',
        'logo',
        'trangthai',
    ];
    public $timestamps = false;

    // ===========================================================================================================================
    // CÁC MỐI QUAN HỆ (RELATIONSHIPS)
    // ===========================================================================================================================
    public function sanpham(): HasMany
    {
        return $this->hasMany(SanphamModel::class, 'id_thuonghieu','id');
    }

    public function quatangsukien(): HasMany
    {
        return $this->hasMany(QuatangsukienModel::class, 'id_thuonghieu','id');
    }
}
