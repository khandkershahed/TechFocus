<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CookieConsent extends Model
{
    use HasFactory;

    protected $fillable = [
        'ip_address',
        'user_agent',
        'consent_token',
        'preferences',
        'accepted',
        'consented_at'
    ];

    protected $casts = [
        'preferences' => 'array',
        'accepted' => 'boolean',
        'consented_at' => 'datetime'
    ];

    /**
     * Check if user has already accepted cookies
     */
    public static function hasAccepted($ipAddress = null)
    {
        if (!$ipAddress) {
            $ipAddress = request()->ip();
        }
        
        return self::where('ip_address', $ipAddress)
                   ->where('accepted', true)
                   ->exists();
    }

    /**
     * Get user's consent preferences
     */
    public static function getUserPreferences($ipAddress = null)
    {
        if (!$ipAddress) {
            $ipAddress = request()->ip();
        }
        
        $consent = self::where('ip_address', $ipAddress)
                      ->where('accepted', true)
                      ->latest()
                      ->first();
        
        return $consent ? $consent->preferences : null;
    }

    /**
     * Generate unique consent token
     */
    public static function generateToken()
    {
        return hash('sha256', uniqid(mt_rand(), true) . microtime());
    }
}