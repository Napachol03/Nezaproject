<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class QuotationDetailModel extends Model
{
    protected $table = 'tbl_nexa_quotation_detail';
    protected $primaryKey = 'detail_id';
    public $incrementing = true;
    public $timestamps = false; // ตารางนี้ไม่มี created_at/updated_at

    protected $fillable = [
        'quotation_id',
        'product_id',
        'item_order',
        'description',
        'quantity',
        'unit',
        'unit_price',
    ];

    // 'amount' ไม่ใส่ใน fillable เพราะเป็น generated column (STORED) คำนวณจาก quantity * unit_price ในฐานข้อมูลเอง
    protected $casts = [
        'quantity'   => 'decimal:2',
        'unit_price' => 'decimal:2',
        'amount'     => 'decimal:2',
    ];

    public function quotation()
    {
        return $this->belongsTo(QuotationModel::class, 'quotation_id', 'quotation_id');
    }

    public function product()
    {
        return $this->belongsTo(ProductModel::class, 'product_id', 'product_id');
    }
}
