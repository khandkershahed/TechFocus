<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Banking extends Model
{
    use HasFactory;

    protected $fillable = [
        'region_id',
        'country_id',
        'month',
        'date',
        'fiscal_year',
        'bank_name',
        'deposit',
        'withdraw',
        'purpose',
        'comments',
        'notes',
        'status'
    ];

   
    

    public function country()
    {
        return $this->belongsTo(Country::class, 'country_id');
    }
}