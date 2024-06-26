<?php

namespace App\Helpers;

use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Session;
use NumberFormatter;

class Currency
{
    public function __invoke(...$params){
        return static::format(...$params);
    }
    public static function format($amount, $currency = null){
        $formatter = new NumberFormatter(config('app.locale'), NumberFormatter::CURRENCY);
        $baseCurrency = config('app.currency', 'USD');
        if ($currency === null) {
            $currency = Session::get('currency_code', $baseCurrency);
        }

        if ($currency != $baseCurrency) {
            $rate = Cache::get('currency_rate_' . $currency, 1);
            $amount = $amount * $rate;
        }
        return $formatter->formatCurrency($amount, $currency);
    }
}
