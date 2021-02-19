<?php


namespace App\Services\Rate;


use App\Models\Currency;
use App\Services\Rate\Directions\Direction;
use App\Services\Rate\Directions\DirectionBuy;
use App\Services\Rate\Sources\RateSourceInterface;

class RateService
{
    private RateSourceInterface $rateSource;

    public function __construct(RateSourceInterface $rateSource)
    {
        $this->rateSource = $rateSource;
    }

    public function getRate(Currency $asset, Currency $currency, ?Direction $direction = null): Rate
    {
        return $this->rateSource->getRate($asset, $currency, $direction);
    }
}
