<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\SoftDeletes;

class NguoidungModel extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'nguoidung';

    protected $fillable = [
        'username',
        'sodienthoai',
        'hoten',
        'gioitinh',
        'ngaysinh',
        'avatar',
        'vaitro',
        'trangthai',
    ];

    protected $hidden = [
        'password', // ⬅️ QUAN TRỌNG: Ẩn mật khẩu khi chuyển sang JSON
    ];

    protected $casts = [
        'ngaysinh'   => 'date:Y-m-d', // ⬅️ Ép kiểu ngày sinh
        'trangthai'  => 'boolean',
        'created_at' => 'datetime:Y-m-d H:i:s',
        'updated_at' => 'datetime:Y-m-d H:i:s',
    ];

    //============================================================
    // MỐI QUAN HỆ (RELATIONSHIPS)
    //===========================================================
    public function diachi(): HasMany
    {
        return $this->hasMany(DiachinguoidungModel::class, 'id_nguoidung');
    }

    public function cuahang(): HasOne
    {
        return $this->hasOne(CuahangModel::class, 'id_nguoidung');
    }
}
