<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ViewModel extends Model
{
    protected $table = 'tbl_nexa_view'; // ⚠️ เปลี่ยนชื่อนี้ให้ตรงกับตารางจริงในฐานข้อมูลของคุณ

    protected $primaryKey = 'view_id';

    public $incrementing = true;

    public $timestamps = false; // ใช้ viewed_at เอง ไม่ใช้ created_at/updated_at

    protected $fillable = [
        'product_id',
        'view_date_timestamp	
',
    ];

    protected $casts = [
        'viewed_at' => 'datetime',
    ];

    public function product()
    {
        return $this->belongsTo(ProductModel::class, 'product_id', 'product_id');
    }
}