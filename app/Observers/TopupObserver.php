<?php

namespace App\Observers;

use App\Models\Topup;

class TopupObserver
{
    public function updated(Topup $topup)
    {
        if ($topup->status_id === Topup::STATUS_DONE && !$topup->originalIsEquivalent('status_id')) {
            $topup->balance->increaseAmount($topup->amount);
        }
    }
}
