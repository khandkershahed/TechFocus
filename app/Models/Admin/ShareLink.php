<?php
// app/Models/ShareLink.php

namespace App\Models\Admin;

use App\Models\Principal;
use Illuminate\Support\Str;
use Rats\Zkteco\Lib\Helper\User;
use Illuminate\Database\Eloquent\Model;

class ShareLink extends Model
{
    protected $fillable = [
        'principal_id',
        'token',
        'allowed_fields',
        'masked_fields', 
        'expires_at',
        'max_views',
        'view_count',
        'allow_download',
        'disable_copy',
        'created_by'
    ];

    protected $casts = [
        'allowed_fields' => 'array',
        'masked_fields' => 'array',
        'expires_at' => 'datetime',
    ];

    public function principal()
    {
        return $this->belongsTo(Principal::class);
    }

    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function isExpired()
    {
        return $this->expires_at->isPast();
    }

    public function hasReachedMaxViews()
    {
        return $this->max_views && $this->view_count >= $this->max_views;
    }

    public function isValid()
    {
        return !$this->isExpired() && !$this->hasReachedMaxViews();
    }

    public function incrementViews()
    {
        $this->increment('view_count');
    }

    public static function generateToken()
    {
        return Str::random(32);
    }

    // Get masked principal data for share link
    public function getMaskedPrincipalData()
    {
        $principal = $this->principal;
        $data = $principal->toArray();
        $maskedData = [];

        foreach ($data as $field => $value) {
            if (in_array($field, $this->allowed_fields)) {
                // Check if field should be masked
                if (in_array($field, $this->masked_fields ?? [])) {
                    $maskedData[$field] = $this->maskField($value, $field);
                } else {
                    $maskedData[$field] = $value;
                }
            } else {
                $maskedData[$field] = null; // Hide field completely
            }
        }

        return $maskedData;
    }

    private function maskField($value, $field)
    {
        if (empty($value)) {
            return $value;
        }

        $stringValue = (string) $value;
        $length = strlen($stringValue);

        if ($length <= 2) {
            return str_repeat('•', $length);
        }

        // Keep first and last character, mask the middle
        $maskLength = max(1, $length - 2);
        return $stringValue[0] . str_repeat('•', $maskLength) . $stringValue[$length - 1];
    }
}