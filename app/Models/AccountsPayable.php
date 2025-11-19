<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AccountsPayable extends Model
{
    use HasFactory;

    protected $fillable = [
        'rfq_id',
        'payment_type',
        'invoice',
        'po_value',
        'due_date',
        'principal_name',
        'principal_po',
        'principal_po_number',
        'principal_amount',
        'principal_payment_status',
        'principal_payment_value',
        'delivery_date',
        'credit_days'
    ];

    public function rfq()
    {
        return $this->belongsTo(Rfq::class, 'rfq_id');
    }
}