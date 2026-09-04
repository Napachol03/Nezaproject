<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CategoryModel extends Model
{
    protected $table = 'tbl_nexa_category';
    protected $primaryKey = 'category_id';
    public $incrementing = true;
    public $timestamps = true; // ตารางนี้มี created_at/updated_at

    protected $fillable = [
        'category_name',
        'parent_id',
    ];

    public function parent()
    {
        return $this->belongsTo(CategoryModel::class, 'parent_id', 'category_id');
    }

    public function children()
    {
        return $this->hasMany(CategoryModel::class, 'parent_id', 'category_id');
    }

    public function products()
    {
        return $this->hasMany(ProductModel::class, 'category_id', 'category_id');
    }
}