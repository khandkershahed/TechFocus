<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AccountsReceivable extends Model
{
    use HasFactory;

    protected $fillable = [
        'rfq_id',
        'payment_type',
        'po_date',
        'due_date',
        'client_po_number',
        'client_name',
        'client_po',
        'invoice',
        'client_amount',
        'client_payment_status',
        'client_payment_value',
        'client_money_receipt',
        'credit_days'
    ];

    public function rfq()
    {
        return $this->belongsTo(Rfq::class, 'rfq_id');
    }
}