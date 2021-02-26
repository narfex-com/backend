<?php


namespace App\Services\Balance;


use App\Models\Balance;
use App\Models\Currency;
use App\Models\User;

class BalanceService
{
    private BalanceManager $balanceManager;

    public function __construct(BalanceManager $balanceManager)
    {
        $this->balanceManager = $balanceManager;
    }

    /**
     * @param User $user
     * @param Currency $currency
     * @return Balance
     * @throws \App\Exceptions\Balance\CurrencyNotImplementedException
     */
    public function create(User $user, Currency $currency): Balance
    {
        /** @var Balance|null $balance */
        $balance = $balance = $user->balances()->where('currency_id', $currency->id)->first();
        if ($balance) {
            return $balance;
        }

        return $this->balanceManager->manager($currency)->create($user);
    }
}
