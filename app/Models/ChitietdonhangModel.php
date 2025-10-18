<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ChitietdonhangModel extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'chitiet_donhang';
    protected $primaryKey = 'id';
    protected $fillable = [
        'id_bienthe',
        'id_donhang',
        'soluong',
        'dongia',
    ];
    public $timestamps = false;

    // ===========================================================================================================================
    // CÁC MỐI QUAN HỆ (RELATIONSHIPS)
    // ===========================================================================================================================
    public function donhang()
    {
        return $this->belongsTo(DonhangModel::class, 'id_donhang', 'id');
    }

    public function bienthe()
    {
        return $this->belongsTo(BientheModel::class, 'id_bienthe', 'id');
    }


    // ???===
    public function sanpham()
    {
        return $this->belongsTo(BientheModel::class, 'id_bienthe')
                    ->with('sanpham');
    }
}
