<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CustomerModel extends Model
{
    protected $table = 'tbl_nexa_customer';
    protected $primaryKey = 'customer_id';
    public $incrementing = true;
    public $timestamps = false; // ตารางนี้มีแค่ created_at (default CURRENT_TIMESTAMP) ไม่มี updated_at

    protected $fillable = [
        'customer_name',
        'address',
        'tel',
        'tax_id',
    ];

    public function quotations()
    {
        return $this->hasMany(QuotationModel::class, 'customer_id', 'customer_id');
    }
}
