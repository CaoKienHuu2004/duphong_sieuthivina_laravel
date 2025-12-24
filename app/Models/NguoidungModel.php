<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\SoftDeletes;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class NguoidungModel extends Authenticatable
// class NguoidungModel extends User
{
    use HasApiTokens, HasFactory, SoftDeletes, Notifiable;

    protected $table = 'nguoidung';
    protected $primaryKey = 'id';
    protected $fillable = [
        'username',
        'password',
        'sodienthoai',
        'hoten',
        'email',
        'gioitinh',
        'ngaysinh',
        'avatar',
        'vaitro',
        'trangthai',
    ];
    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $cast = [
        'ngaysinh' => 'date',
    ];

    public $timestamps = false;

    // ===========================================================================================================================
    // CÁC MỐI QUAN HỆ (RELATIONSHIPS)
    // ===========================================================================================================================
    public function diachi(): HasMany
    {
        return $this->hasMany(DiachinguoidungModel::class, 'id_nguoidung');
    }
    public function baiviet(): HasMany
    {
        return $this->hasMany(BaivietModel::class, 'id_nguoidung');
    }

    public function donhang(): HasMany
    {
        return $this->hasMany(DonhangModel::class, 'id_nguoidung','id');
    }
}
