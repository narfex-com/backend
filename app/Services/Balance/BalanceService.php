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

    public function create(User $user, Currency $currency): Balance
    {
        return $this->balanceManager->manager($currency)->create($user);
    }
}
