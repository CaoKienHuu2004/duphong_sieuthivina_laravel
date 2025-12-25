<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TrangnoidungModel extends Model
{
    use HasFactory;
    protected $table = 'trang_noidung';
    protected $fillable = ['tieude', 'slug', 'noidung', 'trangthai'];

    public $timestamps = true;
}