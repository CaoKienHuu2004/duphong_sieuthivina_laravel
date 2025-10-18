<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ThongbaoModel extends Model
{
    use HasFactory,SoftDeletes;

    protected $table = 'thongbao';
    protected $primaryKey = 'id';
    protected $fillable = [
        'id_nguoidung',
        'tieude',
        'noidung',
        'lienket',
        'trangthai',
    ];
    public $timestamps = false;

    // ===========================================================================================================================
    // CÁC MỐI QUAN HỆ (RELATIONSHIPS)
    // ===========================================================================================================================
    public function nguoidung()
    {
        return $this->belongsTo(NguoidungModel::class, 'id_nguoidung','id');
    }


    public function scopeChuaDoc($query)
    {
        return $query->where('trangthai', 'Chưa đọc');
    }

    public function scopeDaDoc($query)
    {
        return $query->where('trangthai', 'Đã đọc');
    }

    public function scopeTamAn($query)
    {
        return $query->where('trangthai', 'Tạm ẩn');
    }

    // Đánh dấu thông báo là đã đọc
    public function danhDauDaDoc()
    {
        $this->update(['trangthai' => 'Đã đọc']);
    }
}
