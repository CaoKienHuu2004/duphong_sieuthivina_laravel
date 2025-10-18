<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class TukhoaModel extends Model
{
    use HasFactory;

    protected $table = 'tukhoa';
    protected $primaryKey = 'id';
    protected $fillable = [
        'tukhoa',
        'luottruycap',
    ];
    public $timestamps = false;
    
}
