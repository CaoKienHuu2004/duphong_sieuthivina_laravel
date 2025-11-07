<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class PhivanchuyenModel extends Model
{
    use HasFactory;

    protected $table = 'phivanchuyen';
    protected $primaryKey = 'id';
    protected $fillable = [
        'id_nguoidung',
        'ten',
        'phi',
        'trangthai',
    ];
    public $timestamps = false;

    // ===========================================================================================================================
    // CÁC MỐI QUAN HỆ (RELATIONSHIPS)
    // ===========================================================================================================================
    public function donhang(): BelongsTo
    {
        return $this->belongsTo(DonhangModel::class, 'id_phivanchuyen');
    }
    
}
