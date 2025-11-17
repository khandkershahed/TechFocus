<?php

namespace App\Helpers;

class MaskHelper
{
    public static function maskSensitiveData($text)
    {
        if (filter_var($text, FILTER_VALIDATE_EMAIL)) {
            return self::maskEmail($text);
        }
        
        if (preg_match('/^\+?[\d\s\-\(\)]+$/', $text)) {
            return self::maskPhone($text);
        }
        
        return $text;
    }
    
    public static function maskEmail($email)
    {
        $parts = explode('@', $email);
        if (count($parts) === 2) {
            $username = $parts[0];
            $domain = $parts[1];
            
            if (strlen($username) > 2) {
                $maskedUsername = substr($username, 0, 2) . '***';
            } else {
                $maskedUsername = $username . '***';
            }
            
            return $maskedUsername . '@' . $domain;
        }
        
        return $email;
    }
    
    public static function maskPhone($phone)
    {
        $cleaned = preg_replace('/\D/', '', $phone);
        if (strlen($cleaned) > 4) {
            return '***' . substr($cleaned, -4);
        }
        return $phone;
    }
    
    public static function maskUrl($url)
    {
        $parsed = parse_url($url);
        if (isset($parsed['host'])) {
            return $parsed['host'] . ' (Masked URL)';
        }
        return '*** (Masked URL)';
    }
}