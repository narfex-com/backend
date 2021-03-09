<?php

namespace App\Observers;

use App\Models\Exchange;
use App\Models\Transaction;
use App\Services\Hedge\HedgeService;

class ExchangeObserver
{
    private HedgeService $hedgeService;

    /**
     * ExchangeObserver constructor.
     * @param HedgeService $hedgeService
     */
    public function __construct(HedgeService $hedgeService)
    {
        $this->hedgeService = $hedgeService;
    }


    public function created(Exchange $exchange)
    {
        $transaction = new Transaction();
        $transaction->user_id = $exchange->user_id;
        $transaction->from_balance_id = $exchange->from_balance_id;
        $transaction->to_balance_id = $exchange->to_balance_id;
        $transaction->from_currency_id = $exchange->fromBalance->currency_id;
        $transaction->to_currency_id = $exchange->toBalance->currency_id;
        $transaction->typeable()->associate($exchange);
        $transaction->amount = $exchange->to_amount;
        $transaction->created_at = $exchange->created_at;
        $transaction->updated_at = $exchange->updated_at;

        $transaction->save();
        $this->hedgeService->createHedge($exchange);
    }
}
