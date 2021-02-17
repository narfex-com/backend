<?php


namespace App\Services\Balance\CurrencyServices;


use App\Models\Balance;
use App\Models\Currency;
use App\Models\User;

class BtcService extends BaseCurrencyService implements CurrencyService
{
    public function create(User $user): Balance
    {
        $balance = new Balance();
        $balance->user_id = $user->id;
        $balance->currency_id = $this->currency->id;
        $balance->address = $this->getNewAddress();
        $balance->save();

        return $balance;
    }

    private function getNewAddress(): string
    {
        return \Str::random(40);
    }
}
