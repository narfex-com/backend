<?php


namespace App\Helpers;


class NumberFormatter
{
    public static function formatCurrency(float $amount, $isCrypto = false): float
    {
        return $isCrypto ? round($amount, 8, PHP_ROUND_HALF_DOWN) : round($amount, 2, PHP_ROUND_HALF_DOWN);
    }
}
