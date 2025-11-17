<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PrincipalLink extends Model
{
    use HasFactory;

    protected $fillable = [
        'principal_id',
        'label',
        'url',
        'type',
        'file', // matches DB column
    ];

    protected $casts = [
        'label' => 'array',
        'url' => 'array',
        'type' => 'array',
        'file' => 'array', // cast JSON to array
    ];

    public function shareTokens()
{
    return $this->hasMany(ShareToken::class);
}
}
