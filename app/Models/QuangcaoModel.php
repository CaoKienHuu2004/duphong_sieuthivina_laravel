<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class QuangcaoModel extends Model
{
    use HasFactory;
    protected $table = 'quangcao';
    protected $primaryKey = 'id';
    protected $fillable = [
        'vitri',
        'hinhanh',
        'lienket',
        'mota',
        'trangthai'
    ];
    public $timestamps = false;
}
