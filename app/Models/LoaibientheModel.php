<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class LoaibientheModel extends Model
{
    use HasFactory;

    protected $table = 'loaibienthe';
    protected $primaryKey = 'id';
    protected $fillable = [
        'ten',
        'trangthai',
    ];
    public $timestamps = false;

    // ===========================================================================================================================
    // CÁC MỐI QUAN HỆ (RELATIONSHIPS)
    // ===========================================================================================================================
    public function bienthe(): HasMany
    {
        return $this->hasMany(BientheModel::class, 'id_loaibienthe');
    }
}
