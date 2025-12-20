<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PrivacySection extends Model
{
    use HasFactory;

    protected $fillable = [
        'policy_id',
        'section_title',
        'section_number',
        'section_content',
        'order'
    ];

    public function policy()
    {
        return $this->belongsTo(PrivacyPolicy::class, 'policy_id');
    }
}