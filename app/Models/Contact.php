<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Contact extends Model
{
    use HasFactory;

    protected $fillable = [
        'country_id',
        'code',
        'name',
        'email',
        'phone',
        'subject',
        'message',
        'ip_address',
        'status',
    ];
}
