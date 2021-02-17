<?php

namespace Tests\Feature\Rate;

use App\Exceptions\Rate\Coinbase\CannotGetRateException;
use App\Models\Currency;
use App\Services\Rate\Directions\DirectionBuy;
use App\Services\Rate\Rate;
use App\Services\Rate\Sources\CoinbaseRateSource;
use Database\Seeders\CurrencySeeder;
use Illuminate\Contracts\Container\BindingResolutionException;
use Illuminate\Support\Facades\Redis;
use Tests\TestCase;

class RateTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     * @throws CannotGetRateException
     * @throws BindingResolutionException
     */
    public function test_coinbase()
    {
        $this->seed(CurrencySeeder::class);

        $fiatCurrency = Currency::whereIsFiat(true)->first();
        $cryptoCurrency = Currency::whereIsFiat(false)->first();

        /** @var CoinbaseRateSource $source */
        $source = app()->make(CoinbaseRateSource::class);

        $rate = $source->getRate($cryptoCurrency, $fiatCurrency, new DirectionBuy());

        $cacheKey = 'exchange_rate_' . $cryptoCurrency->code . '_' . $fiatCurrency->code;
        $rateFromRedis = Redis::connection()->client()->get($cacheKey);

        $this->assertEquals(Rate::class, get_class($rate));
        $this->assertEquals($rate->getRate(), $rateFromRedis);
        $this->assertIsFloat($rate->getRate());
    }

    public function test_fiat_to_crypto()
    {
        $this->seed(CurrencySeeder::class);
        $fiatCurrency = Currency::whereCode('rub')->first();
        $cryptoCurrency = Currency::whereCode('btc')->first();

        /** @var CoinbaseRateSource $source */
        $source = app()->make(CoinbaseRateSource::class);

        $rate = $source->getRate($fiatCurrency, $cryptoCurrency, new DirectionBuy());
    }
}
