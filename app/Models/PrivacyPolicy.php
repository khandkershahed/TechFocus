<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PrivacyPolicy extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'content',
        'version',
        'is_active',
        'effective_date'
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'effective_date' => 'date'
    ];

    public function sections()
    {
        return $this->hasMany(PrivacySection::class, 'policy_id');
    }

    public function getActivePolicy()
    {
        return self::where('is_active', true)->latest()->first();
    }
}