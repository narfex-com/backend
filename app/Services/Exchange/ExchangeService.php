<?php


namespace App\Services\Exchange;


use App\Exceptions\Exchange\AccessViolationException;
use App\Exceptions\Exchange\InsufficientFundsException;
use App\Models\Balance;
use App\Models\User;
use App\Services\Rate\Directions\DirectionBuy;
use App\Services\Rate\Directions\DirectionSell;
use App\Services\Rate\RateService;

class ExchangeService
{
    private RateService $rateService;

    public function __construct(RateService $rateService)
    {
        $this->rateService = $rateService;
    }

    public function exchange(User $user, Balance $fromBalance, Balance $toBalance, float $fromAmount, float $toAmount, bool $assetAmount)
    {
        if ($user->id !== $fromBalance->user_id || $user->id !== $toBalance->user_id) {
            throw new AccessViolationException();
        }

        $direction = $fromBalance->currency->is_fiat ? new DirectionBuy() : new DirectionSell();

        $rate = $this->rateService->getRate($fromBalance->currency, $toBalance->currency, $direction);

        if ($assetAmount) {
            $amount = $rate->getPriceWithFee($fromAmount);
        }

        if (!$assetAmount) {
            $currencyAmountRate = $rate->getRevertedRate();
            $amount = $currencyAmountRate->getPriceWithFee($toAmount);
        }

        if ($fromBalance->amount < $amount) {
            throw new InsufficientFundsException();
        }
    }
}
