<?php


namespace App\Services\Topup;


use App\Exceptions\Topup\TopupCurrencyNotFoundException;
use App\Models\Balance;
use App\Models\Currency;
use App\Models\User;

class TopupService
{
    private TopupManager $topupManager;

    public function __construct(TopupManager $topupManager)
    {
        $this->topupManager = $topupManager;
    }

    /**
     * @param Balance $balance
     * @param float $amount
     * @return Topup
     * @throws TopupCurrencyNotFoundException
     */
    public function create(Balance $balance, float $amount): Topup
    {
        return $this->topupManager->get($balance->currency)->create($balance, $amount);
    }
}
