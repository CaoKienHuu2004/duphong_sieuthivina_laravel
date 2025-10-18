<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;


class DiachinguoidungModel extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'diachi_nguoidung';
    protected $primaryKey = 'id';
    protected $fillable = [
        'id_nguoidung',
        'hoten',
        'sodienthoai',
        'diachi',
        'trangthai',
    ];
    public $timestamps = false;

    // ===========================================================================================================================
    // CÁC MỐI QUAN HỆ (RELATIONSHIPS)
    // ===========================================================================================================================
    public function nguoidung(): BelongsTo
    {
        return $this->belongsTo(NguoidungModel::class, 'id_nguoidung');
    }
    public function donhang(): HasMany
    {
        return $this->hasMany(DonhangModel::class, 'id_diachinguoidung','id');
    }
}

