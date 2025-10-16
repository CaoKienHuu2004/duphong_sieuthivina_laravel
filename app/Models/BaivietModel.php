<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BaivietModel extends Model
{
    use HasFactory;

    protected $table = 'baiviet';
    protected $primaryKey = 'id';
    protected $fillable = [
        'id_nguoidung',
        'tieude',
        'slug',
        'noidung',
        'luotxem',
        'hinhanh',
        'trangthai',
    ];
    public $timestamps = false;

    protected $casts = [
        'luotxem' => 'integer',
    ];

    protected $attributes = [
        'trangthai' => 'Hiển thị',
        'luotxem' => 0,
    ];

    // ===========================================================================================================================
    // CÁC MỐI QUAN HỆ (RELATIONSHIPS)
    // ===========================================================================================================================
    public function nguoidung()
    {
        return $this->belongsTo(NguoidungModel::class, 'id_nguoidung');
    }
}
