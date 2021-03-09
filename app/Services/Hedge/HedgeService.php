<?php


namespace App\Services\Hedge;


use App\Models\Exchange;
use App\Models\Hedge;

class HedgeService
{
    private HedgeMarketManager $marketManager;

    /**
     * HedgeService constructor.
     * @param HedgeMarketManager $marketManager
     */
    public function __construct(HedgeMarketManager $marketManager)
    {
        $this->marketManager = $marketManager;
    }


    public function createHedge(Exchange $exchange): ?Hedge
    {
        return null;
    }

    public function createHedgeOrder(Hedge $hedge)
    {
        return $this->marketManager->createHedgeOrder($hedge);
    }
}
