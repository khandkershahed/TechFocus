<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MovementRecord extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'status',
        'date',
        'start_time',
        'end_time',
        'duration',
        'area',
        'transport',
        'cost',
        'meeting_type',
        'company',
        'contact_person',
        'contact_number',
        'value',
        'value_status',
        'purpose',
        'comments',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'date' => 'date',
        'cost' => 'decimal:2',
        'value' => 'decimal:2',
        'start_time' => 'datetime:H:i:s',
        'end_time' => 'datetime:H:i:s',
        'duration' => 'datetime:H:i:s',
    ];
}