<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class PhuongthucModel extends Model
{
    use HasFactory;

    protected $table = 'phuongthuc';
    protected $primaryKey = 'id';
    protected $fillable = [
        'ten',
        'maphuongthuc',
        'trangthai',
    ];
    public $timestamps = false;

    // ===========================================================================================================================
    // CÁC MỐI QUAN HỆ (RELATIONSHIPS)
    // ===========================================================================================================================
    public function donhang(): HasMany
    {
        return $this->hasMany(DonhangModel::class, 'id_phuongthuc');
    }

    // Scope: Lấy các phương thức đang hoạt động
    public function scopeHoatDong($query)
    {
        return $query->where('trangthai', 'Hoạt động');
    }

    // Scope: Lấy các phương thức đang bị tạm khóa
    public function scopeTamKhoa($query)
    {
        return $query->where('trangthai', 'Tạm khóa');
    }

    // Scope: Lấy các phương thức đã dừng hoạt động
    public function scopeDungHoatDong($query)
    {
        return $query->where('trangthai', 'Dừng hoạt động');
    }
}
