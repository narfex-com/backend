<?php


namespace App\Services\Rate\Sources;


use App\Models\Currency;
use App\Services\Rate\Directions\Direction;
use App\Services\Rate\Rate;

interface RateSourceInterface
{
    public function getRate(Currency $asset, Currency $currency, Direction $direction): Rate;
}
