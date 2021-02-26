<?php


namespace App\Services\Exchange;


use App\Exceptions\Exchange\AccessViolationException;
use App\Exceptions\Exchange\InsufficientFundsException;
use App\Models\Balance;
use App\Models\User;
use App\Services\Rate\RateService;
use Illuminate\Support\Facades\DB;
use App\Models\Exchange as ExchangeModel;

class ExchangeService
{
    private RateService $rateService;

    public function __construct(RateService $rateService)
    {
        $this->rateService = $rateService;
    }

    public function exchange(User $user, Balance $fromBalance, Balance $toBalance, float $fromAmount, float $toAmount, bool $assetAmount): ExchangeModel
    {
        if ($user->id !== $fromBalance->user_id || $user->id !== $toBalance->user_id) {
            throw new AccessViolationException();
        }

        $rate = $this->rateService->getExchangeRate($fromBalance->currency, $toBalance->currency)->withFee();

        if ($assetAmount) {
            $toAmount = $rate->getPrice($fromBalance->currency, $fromAmount);
        }

        if (!$assetAmount) {
            $fromAmount = $rate->getPrice($toBalance->currency, $toAmount);
        }

        if (!$fromBalance->checkFunds($fromAmount)) {
            throw new InsufficientFundsException();
        }

        /**
         * @var ExchangeModel
         */
        return DB::transaction(function() use ($user, $fromBalance, $toBalance, $fromAmount, $toAmount, $rate){
            $fromBalance->reduceAmount($fromAmount);

            $exchange = new ExchangeModel();
            $exchange->rate = $rate->getRate();
            $exchange->user()->associate($user);
            $exchange->fromBalance()->associate($fromBalance);
            $exchange->toBalance()->associate($toBalance);
            $exchange->fromCurrency()->associate($fromBalance->currency);
            $exchange->toCurrency()->associate($toBalance->currency);
            $exchange->from_amount = $fromAmount;
            $exchange->to_amount = $toAmount;
            $exchange->status_id = ExchangeModel::EXCHANGE_STATUS_CREATED;
            $exchange->save();

            return $exchange;
        });
    }
}
