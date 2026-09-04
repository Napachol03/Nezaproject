<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class QuotationModel extends Model
{
    protected $table = 'tbl_nexa_quotation';
    protected $primaryKey = 'quotation_id';
    public $incrementing = true;
    public $timestamps = true; // ตารางนี้มี created_at/updated_at

    protected $fillable = [
        'quotation_no',
        'running_no',
        'quotation_year_be',
        'quotation_date',
        'customer_id',
        'admin_id',
        'subject',
        'subtotal_amount',
        'vat_rate',
        'vat_amount',
        'total_amount',
        'price_validity_days',
        'payment_terms',
        'status',
    ];

    protected $casts = [
        'quotation_date'   => 'date',
        'subtotal_amount'  => 'decimal:2',
        'vat_rate'         => 'decimal:2',
        'vat_amount'       => 'decimal:2',
        'total_amount'     => 'decimal:2',
    ];

    public function customer()
    {
        return $this->belongsTo(CustomerModel::class, 'customer_id', 'customer_id');
    }

    public function admin()
    {
        return $this->belongsTo(AdminModel::class, 'id', 'id');
    }

    public function details()
    {
        return $this->hasMany(QuotationDetailModel::class, 'quotation_id', 'quotation_id');
    }
}
