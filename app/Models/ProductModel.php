<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProductModel extends Model
{
    protected $table = 'tbl_nexa_product';
    protected $primaryKey = 'product_id';
    public $incrementing = true;
    public $timestamps = false;

    protected $fillable = [
        'product_name',
        'description',
        'category_id',
        'attributes',
        'is_featured',
        'is_active',
        'view_count',
    ];

    protected $casts = [
        'attributes'  => 'array',
        'is_featured' => 'boolean',
        'is_active'   => 'boolean',
    ];

    public function category()
    {
        return $this->belongsTo(CategoryModel::class, 'category_id', 'category_id');
    }

    public function images()
    {
        return $this->hasMany(ProductImageModel::class, 'product_id', 'product_id');
    }

    public function quotationDetails()
    {
        return $this->hasMany(QuotationDetailModel::class, 'product_id', 'product_id');
    }

    public function views()
    {
        return $this->hasMany(ViewModel::class, 'product_id', 'product_id');
    }
    
}