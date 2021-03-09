<?php


namespace App\Services\Hedge;


use App\Models\Exchange;
use App\Models\Hedge;
use App\Services\Hedge\Markets\Binance;
use App\Services\Hedge\Markets\Bitmex;
use App\Services\Hedge\Markets\HedgeMarketInterface;

class HedgeMarketManager
{
    private array $availableMarkets = [
        'binance' => Binance::class,
        'bitmex' => Bitmex::class,
    ];

    public function createHedgeOrder(Hedge $hedge): Hedge
    {
        return app(Binance::class)->createHedgeOrderOnMarket($hedge);
    }
}
