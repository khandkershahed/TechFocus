<?php

namespace App\Helpers;

class CountryHelper
{
    public static function isoCode($countryName)
    {
        $map = [
            'Bangladesh' => 'BD',
            'India' => 'IN',
            'Pakistan' => 'PK',
            'United States' => 'US',
            'United Kingdom' => 'GB',
            'United Arab Emirates' => 'AE',
            'Saudi Arabia' => 'SA',
            'Canada' => 'CA',
            'Australia' => 'AU',
        ];

        return $map[$countryName] ?? null;
    }
}
