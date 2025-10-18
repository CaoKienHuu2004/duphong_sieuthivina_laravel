<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;
class BientheModel extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'bienthe';
    protected $primaryKey = 'id';
    protected $fillable = [
        'id_loaibienthe',
        'id_sanpham',
        'giagoc',
        'soluong',
        'luottang',
        'luotban',
        'trangthai',
    ];
    public $timestamps = false;

    // ===========================================================================================================================
    // CÁC MỐI QUAN HỆ (RELATIONSHIPS)
    // ===========================================================================================================================
    public function sanpham(): BelongsTo
    {
        return $this->belongsTo(SanphamModel::class, 'id_sanpham','id');
    }

    public function loaibienthe(): BelongsTo
    {
        return $this->belongsTo(LoaibientheModel::class, 'id_loaibienthe','id');
    }
}
