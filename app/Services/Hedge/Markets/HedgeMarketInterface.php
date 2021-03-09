<?php


namespace App\Services\Hedge\Markets;



use App\Models\Exchange;
use App\Models\Hedge;

interface HedgeMarketInterface
{
    public function createHedgeOrderOnMarket(Hedge $hedge): Hedge;

    public function closeHedgeOrder(Hedge $hedge);
}
