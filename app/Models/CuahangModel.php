<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class CuahangModel extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'thuonghieu';
    protected $fillable = [
        'ten',
        'slug',
        'logo',
        'trangthai',
    ];
    protected $casts = [
        'created_at' => 'datetime:Y-m-d H:i:s',
        'updated_at' => 'datetime:Y-m-d H:i:s',
    ];

    public function sanpham(): HasMany
    {
        return $this->hasMany(SanphamModel::class, 'id_thuonghieu');
    }

}
