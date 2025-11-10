<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PrincipalAddress extends Model
{
    use HasFactory;

    protected $fillable = [
        'principal_id',
        'type',
        'line1',
        'line2',
        'city',
        'state',
        'postal',
        'country_iso',
    ];

    public function principal()
    {
        return $this->belongsTo(Principal::class);
    }
}
