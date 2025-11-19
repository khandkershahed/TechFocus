<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Income extends Model
{
    use HasFactory;

    protected $fillable = [
        'rfq_id',
        'order_id',
        'date',
        'month',
        'po_reference',
        'type',
        'client_name',
        'amount',
        'received_value'
    ];

    protected $casts = [
        'type' => 'string'
    ];

    public function rfq()
    {
        return $this->belongsTo(Rfq::class, 'rfq_id');
    }

    // public function order()
    // {
    //     return $this->belongsTo(Order::class, 'order_id');
    // }
}