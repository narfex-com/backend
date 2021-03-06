<?php

namespace Tests\Feature\Rate;

use App\Exceptions\Rate\Coinbase\CannotGetRateException;
use App\Helpers\NumberFormatter;
use App\Models\Currency;
use App\Services\Rate\Directions\DirectionBuy;
use App\Services\Rate\Directions\DirectionSell;
use App\Services\Rate\Rate;
use App\Services\Rate\RateService;
use App\Services\Rate\Sources\CoinbaseRateSource;
use Database\Seeders\CurrencySeeder;
use Illuminate\Contracts\Container\BindingResolutionException;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Redis;
use Tests\TestCase;

class RateTest extends TestCase
{
    use RefreshDatabase;

    /**
     * A basic feature test example.
     *
     * @return void
     * @throws CannotGetRateException
     * @throws BindingResolutionException
     */
    public function test_coinbase_crypto_to_fiat()
    {
        $this->seed(CurrencySeeder::class);

        $fiatCurrency = Currency::whereIsFiat(true)->first();
        $cryptoCurrency = Currency::whereIsFiat(false)->first();

        /** @var CoinbaseRateSource $source */
        $source = app()->make(CoinbaseRateSource::class);

        $direction = new DirectionSell();
        $rate = $source->getRate($cryptoCurrency, $fiatCurrency, $direction);

        $expectedRate = $source->getRateFromCoinbase($cryptoCurrency, $fiatCurrency, $direction);
        $expectedRate += $expectedRate * 0.04;

        $cacheKey = 'exchange_rate_' . $cryptoCurrency->code . '_' . $fiatCurrency->code . '_' . $direction->getDirection();
        $rateFromRedis = Redis::connection()->client()->get($cacheKey);

        $this->assertEquals(Rate::class, get_class($rate));
        $this->assertEquals($rate->getRate(), $rateFromRedis);
        $this->assertIsFloat($rate->getRate());
        $this->assertIsFloat($expectedRate, $rate->withFee()->getRate());
    }

    public function test_coinbase_fiat_to_crypto()
    {
        $this->seed(CurrencySeeder::class);
        $fiatCurrency = Currency::whereCode('rub')->first();
        $cryptoCurrency = Currency::whereCode('btc')->first();

        /** @var CoinbaseRateSource $source */
        $source = app()->make(CoinbaseRateSource::class);
        $rateService = app()->make(RateService::class);

        $direction = new DirectionBuy();
        $rate = $rateService->getExchangeRate($fiatCurrency, $cryptoCurrency);

        $coinbaseRate = $source->getRateFromCoinbase($fiatCurrency, $cryptoCurrency, $direction);
        $fee = $coinbaseRate * 0.04;
        $coinbaseRateWithFee = $coinbaseRate + $fee;
        $expectedRate = 1 / $coinbaseRateWithFee;
        $rateWithFee = $rate->withFee()->getRate();
        $this->assertEquals(NumberFormatter::formatCurrency($coinbaseRateWithFee), NumberFormatter::formatCurrency(1 / $rateWithFee));
        $this->assertEquals($expectedRate, $rateWithFee);
    }

    public function test_get_all_rates()
    {
        $this->seed(CurrencySeeder::class);

        $currencies = Currency::available()->get();

        $response = $this->get(route('rates.index'));
        $rateService = app()->make(RateService::class);

        $this->assertEquals(200, $response->getStatusCode());

        $rates = json_decode($response->content(), true)['data'];
        $rates = collect($rates);

        foreach ($currencies as $baseCurrency) {
            foreach ($currencies as $currency) {
                if ($baseCurrency->is_fiat === $currency->is_fiat) continue;

                $rateExists = $rates->filter(function($rate) use ($baseCurrency, $currency, $rateService){
                    return $rate['pair'] === "{$baseCurrency->code}-{$currency->code}";
                })->first();
                $this->assertIsArray($rateExists);
                $rate = $rateService->getExchangeRate($baseCurrency, $currency)->withFee()->getRate();
                $this->assertEquals($rate, $rateExists['rate']);
            }
        }
    }
}
