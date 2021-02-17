<?php


namespace App\Services\Balance;


use App\Exceptions\Balance\CurrencyNotImplementedException;
use App\Models\Currency;
use App\Services\Balance\CurrencyServices\BtcService;
use App\Services\Balance\CurrencyServices\CurrencyService;
use App\Services\Balance\CurrencyServices\IdrService;

class BalanceManager
{
    private array $currencies = [
        'idr' => IdrService::class,
        'btc' => BtcService::class
    ];

    /**
     * @param Currency $currency
     * @return CurrencyService
     * @throws CurrencyNotImplementedException
     */
    public function manager(Currency $currency): CurrencyService
    {
        $code = $currency->code;
        if (!isset($this->currencies[$code])) {
            throw new CurrencyNotImplementedException();
        }

        return new $this->currencies[$currency]($currency);
    }
}
