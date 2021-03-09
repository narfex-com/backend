<?php


namespace App\Services\Hedge\Markets;


use App\Models\Exchange;
use App\Models\Hedge;

class Binance implements HedgeMarketInterface
{

    public function createHedgeOrderOnMarket(Hedge $hedge): Hedge
    {
        // TODO: Implement createHedgeOrder() method.
    }

    public function closeHedgeOrder(Hedge $hedge)
    {
        // TODO: Implement closeHedgeOrder() method.
    }
}
