<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProductImageModel extends Model
{
    protected $table = 'tbl_nexa_product_image';
    protected $primaryKey = 'image_id';
    public $incrementing = true;
    public $timestamps = false; // ตารางนี้มีแค่ created_at ไม่มี updated_at

    const UPDATED_AT = null;

    protected $fillable = [
        'product_id',
        'image_url',
        'is_primary',
        'sort_order',
    ];

    protected $casts = [
        'is_primary' => 'boolean',
    ];

    public function product()
    {
        return $this->belongsTo(ProductModel::class, 'product_id', 'product_id');
    }
}