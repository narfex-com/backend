<?php


namespace App\Services\Rate\Sources;


use App\Models\Currency;
use App\Services\Rate\Directions\Direction;
use App\Services\Rate\Rate;

interface RateSourceInterface
{
    public function getRate(Currency $asset, Currency $currency, ?Direction $direction = null): Rate;

    public function getExchangeRate(Currency $currency, Currency $asset, bool $isLiveRate = false): Rate;

    public function getRatesByCurrency(Currency $currency): array;
}
