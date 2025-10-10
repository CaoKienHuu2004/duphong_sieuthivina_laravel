<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use App\Models\SanphamModel;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class DanhmucModel extends Model
{
    use HasFactory;
    protected $table = 'danhmuc'; // Tên bảng trong cơ sở dữ liệu
    protected $primaryKey = 'id'; //
    protected $fillable = ['ten', 'slug','logo','created_at','updated_at']; // Các cột cho phép gán hàng loạt

    protected $casts = [
        'created_at' => 'datetime:Y-m-d H:i:s',
        'updated_at' => 'datetime:Y-m-d H:i:s',
    ];

    /**
     * Một Danh mục có nhiều Sản phẩm.
     */
    // public function products(): BelongsToMany
    // {
    //     // Laravel sẽ tự động tìm bảng trung gian 'category_product'
    //     // và khóa ngoại 'category_id', 'product_id'.
    //     return $this->belongsToMany(SanphamModel::class);
    // }
}
