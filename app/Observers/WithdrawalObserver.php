<?php

namespace App\Observers;

use App\Models\Transaction;
use App\Models\Withdrawal;

class WithdrawalObserver
{
    public function created(Withdrawal $withdrawal)
    {
        $transaction = new Transaction();
        $transaction->user_id = $withdrawal->user_id;
        $transaction->from_balance_id = $withdrawal->balance_id;
        $transaction->from_currency_id = $withdrawal->currency_id;
        $transaction->typeable()->associate($withdrawal);
        $transaction->amount = $withdrawal->amount;
        $transaction->created_at = $withdrawal->created_at;
        $transaction->updated_at = $withdrawal->updated_at;

        $transaction->save();
    }
}
