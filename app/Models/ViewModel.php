<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ViewModel extends Model
{
<<<<<<< HEAD
    protected $table = 'tbl_nexa_view';
=======
    protected $table = 'tbl_nexa_view'; // ⚠️ เปลี่ยนชื่อนี้ให้ตรงกับตารางจริงในฐานข้อมูลของคุณ
>>>>>>> 19bea7484cccea031972b54bada982e94bcc8b3c

    protected $primaryKey = 'view_id';

    public $incrementing = true;

    public $timestamps = false; // ใช้ viewed_at เอง ไม่ใช้ created_at/updated_at

    protected $fillable = [
        'product_id',
<<<<<<< HEAD
        'viewed_at',
=======
        'view_date_timestamp	
',
>>>>>>> 19bea7484cccea031972b54bada982e94bcc8b3c
    ];

    protected $casts = [
        'viewed_at' => 'datetime',
    ];

    public function product()
    {
        return $this->belongsTo(ProductModel::class, 'product_id', 'product_id');
    }
}