<?php

namespace App\Support;

class CountryCurrency
{
    public const MAP = [
        'PK' => 'PKR',
        'AE' => 'AED',
        'SA' => 'SAR',
        'QA' => 'QAR',
        'KW' => 'KWD',
        'BH' => 'BHD',
        'OM' => 'OMR',
        'JO' => 'JOD',
        'EG' => 'EGP',
        'TR' => 'TRY',
        'IR' => 'IRR',
        'IQ' => 'IQD',
        'YE' => 'YER',
        'AF' => 'AFN',
        'IN' => 'INR',
        'BD' => 'BDT',
        'LK' => 'LKR',
        'MY' => 'MYR',
        'SG' => 'SGD',
        'ID' => 'IDR',
        'PH' => 'PHP',
        'GB' => 'GBP',
        'US' => 'USD',
        'CA' => 'CAD',
        'AU' => 'AUD',
        'NZ' => 'NZD',
        'DE' => 'EUR',
        'FR' => 'EUR',
        'NL' => 'EUR',
        'NG' => 'NGN',
        'KE' => 'KES',
        'ZA' => 'ZAR',
        'GH' => 'GHS',
        'TZ' => 'TZS',
        'OTHER' => 'USD',
    ];

    public static function forCountry(?string $countryCode): string
    {
        if (!$countryCode) {
            return 'USD';
        }

        return self::MAP[strtoupper($countryCode)] ?? 'USD';
    }
}
