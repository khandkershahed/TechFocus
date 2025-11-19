<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AccountProfitLoss extends Model
{
    use HasFactory;

    protected $fillable = [
        'rfq_id',
        'sales_price',
        'cost_price',
        'gross_makup_percentage',
        'gross_makup_ammount',
        'net_profit_percentage',
        'net_profit_ammount',
        'profit',
        'loss'
    ];

    public function rfq()
    {
        return $this->belongsTo(Rfq::class, 'rfq_id');
    }
}