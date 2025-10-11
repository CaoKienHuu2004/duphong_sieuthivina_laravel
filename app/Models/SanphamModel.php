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
    protected $fillable = [
        'id_cuahang',
        'ten',
        'slug',
        'mota',
        'xuatxu',
        'sanxuat',
        'trangthai',
        'giamgia',
        'luotxem',
        'luotban',
        'thuonghieu'
    ];

    protected $casts = [
        'created_at' => 'datetime:Y-m-d H:i:s',
        'updated_at' => 'datetime:Y-m-d H:i:s',
    ];

    public function danhmuc(): BelongsToMany
    {
        return $this->belongsToMany(DanhmucModel::class);
    }

    public function bienthe(): HasMany
    {
        return $this->hasMany(BientheModel::class, 'id_sanpham');
    }

    public function cuahang(): BelongsTo
    {
        return $this->belongsTo(CuahangModel::class, 'id_cuahang');
    }

    public function hinhanhsanpham(): HasMany
    {
        return $this->hasMany(HinhanhsanphamModel::class, 'id_sanpham');
    }
}
