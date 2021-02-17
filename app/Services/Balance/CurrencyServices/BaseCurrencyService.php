<?php


namespace App\Services\Balance\CurrencyServices;


use App\Models\Currency;

abstract class BaseCurrencyService implements CurrencyService
{
    protected Currency $currency;

    public function __construct(Currency $currency)
    {
        $this->currency = $currency;
    }
}
