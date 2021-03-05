<?php


namespace App\Services\Topup;


use App\Exceptions\Topup\TopupCurrencyNotFoundException;
use App\Models\Currency;
use App\Services\Topup\Adapters\TopupAdapter;
use App\Services\Topup\Adapters\Xendit;

class TopupManager
{
    private array $currencies = [
        'idr' => Xendit::class,
    ];

    /**
     * @param Currency $currency
     * @return TopupAdapter
     * @throws TopupCurrencyNotFoundException
     */
    public function get(Currency $currency): TopupAdapter
    {
        if (!isset($this->currencies[$currency->code])) {
            throw new TopupCurrencyNotFoundException();
        }

        return app()->make($this->currencies[$currency->code]);
    }
}
