<?php

namespace App\Models;

use Str;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ShareLink extends Model
{
    use HasFactory;

    protected $fillable = [
        'principal_id', 'token', 'expires_at', 'masked_fields', 'allow_copy', 'view_count'
    ];

    protected $casts = [
        'expires_at' => 'datetime',
        'masked_fields' => 'array',
    ];

    public function principal()
    {
        return $this->belongsTo(Principal::class);
    }

    public function isExpired()
    {
        return $this->expires_at && $this->expires_at->isPast();
    }

    public function incrementViewCount()
    {
        $this->increment('view_count');
    }

    // Generate a unique token
    public static function generateToken()
    {
        do {
            $token = Str::random(32);
        } while (self::where('token', $token)->exists());

        return $token;
    }
}