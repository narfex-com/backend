<?php


namespace App\Services\Withdrawal;


use App\Exceptions\Withdrawal\CurrencyNotSupportedException;
use App\Models\Currency;
use App\Services\Withdrawal\Adapters\BtcAdapter;
use App\Services\Withdrawal\Adapters\IdrAdapter;
use App\Services\Withdrawal\Adapters\WithdrawalAdapter;

class WithdrawalProcessManager
{
    private array $adapters = [
        'idr' => IdrAdapter::class,
        'btc' => BtcAdapter::class,
    ];

    public function make(Currency $currency): WithdrawalAdapter
    {
        if (!isset($this->adapters[$currency->code])) {
            throw new CurrencyNotSupportedException();
        }

        return app($this->adapters[$currency->code]);
    }
}
