<?php

namespace Tests\Feature\Exchange;

use App\Models\Exchange;
use App\Models\User;
use App\Services\Exchange\ExchangeService;
use App\Services\Rate\RateService;
use App\Services\Rate\Sources\RateSource;
use Database\Seeders\CurrencySeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ExchangeTest extends TestCase
{
    use RefreshDatabase;

    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_exchange_crypto_to_fiat_with_from_amount()
    {
        RateSource::setTestRate(1000000);
        $this->seed(CurrencySeeder::class);
        $user = User::factory()->create();

        $fromBalance = $user->balances()->whereHas('currency', function($query){
            $query->whereCode('btc');
        })->first();
        $toBalance = $user->balances()->whereHas('currency', function($query){
            $query->whereCode('rub');
        })->first();

        $fromAmount = 0.1;
        $toAmount = 0;

        /** @var ExchangeService $exchangeService */
        $exchangeService = app()->make(ExchangeService::class);
        /** @var RateService $rateService */
        $rateService = app()->make(RateService::class);

        $currentRate = $rateService->getExchangeRate($fromBalance->currency, $toBalance->currency)->withFee();
        $rate = $currentRate->getRate();

        $expectedAmount = $fromAmount * $rate;

        $exchange = $exchangeService->exchange($user, $fromBalance, $toBalance, $fromAmount, $toAmount, true);

        $this->assertEquals(Exchange::class, get_class($exchange));
        $this->assertEquals($expectedAmount, $exchange->to_amount);

        RateSource::unsetTestRate();
    }

    public function test_exchange_crypto_to_fiat_with_to_amount()
    {
        RateSource::setTestRate(1000000);
        $this->seed(CurrencySeeder::class);
        $user = User::factory()->create();

        $fromBalance = $user->balances()->whereHas('currency', function($query){
            $query->whereCode('btc');
        })->first();
        $toBalance = $user->balances()->whereHas('currency', function($query){
            $query->whereCode('rub');
        })->first();

        $fromAmount = 0;
        $toAmount = 100000;

        /** @var ExchangeService $exchangeService */
        $exchangeService = app()->make(ExchangeService::class);
        /** @var RateService $rateService */
        $rateService = app()->make(RateService::class);

        $currentRate = $rateService->getExchangeRate($fromBalance->currency, $toBalance->currency)->withFee();
        $expectedAmount = $currentRate->getPrice($toBalance->currency, $toAmount);
        $exchange = $exchangeService->exchange($user, $fromBalance, $toBalance, $fromAmount, $toAmount, false);

        $this->assertEquals(Exchange::class, get_class($exchange));
        $this->assertEquals($expectedAmount, $exchange->from_amount);

        RateSource::unsetTestRate();
    }

    public function test_exchange_fiat_to_crypto_with_from_amount()
    {
        RateSource::setTestRate(1000000);
        $this->seed(CurrencySeeder::class);
        $user = User::factory()->create();

        $fromBalance = $user->balances()->whereHas('currency', function($query){
            $query->whereCode('rub');
        })->first();
        $toBalance = $user->balances()->whereHas('currency', function($query){
            $query->whereCode('btc');
        })->first();

        $fromAmount = 100000;
        $toAmount = 0;

        /** @var ExchangeService $exchangeService */
        $exchangeService = app()->make(ExchangeService::class);
        /** @var RateService $rateService */
        $rateService = app()->make(RateService::class);

        $currentRate = $rateService->getExchangeRate($fromBalance->currency, $toBalance->currency)->withFee();
        $rate = $currentRate->getRate();

        $expectedAmount = $fromAmount * $rate;

        $exchange = $exchangeService->exchange($user, $fromBalance, $toBalance, $fromAmount, $toAmount, true);

        $this->assertEquals(Exchange::class, get_class($exchange));
        $this->assertEquals($expectedAmount, $exchange->to_amount);

        RateSource::unsetTestRate();
    }

    public function test_exchange_fiat_to_crypto_with_to_amount()
    {
        RateSource::setTestRate(1000000);
        $this->seed(CurrencySeeder::class);
        $user = User::factory()->create();

        $fromBalance = $user->balances()->whereHas('currency', function($query){
            $query->whereCode('rub');
        })->first();
        $toBalance = $user->balances()->whereHas('currency', function($query){
            $query->whereCode('btc');
        })->first();

        $fromAmount = 0;
        $toAmount = 0.1;

        /** @var ExchangeService $exchangeService */
        $exchangeService = app()->make(ExchangeService::class);
        /** @var RateService $rateService */
        $rateService = app()->make(RateService::class);

        $currentRate = $rateService->getExchangeRate($fromBalance->currency, $toBalance->currency)->withFee();
        $expectedAmount = $toAmount / $currentRate->getRate();
        $exchange = $exchangeService->exchange($user, $fromBalance, $toBalance, $fromAmount, $toAmount, false);

        $this->assertEquals(Exchange::class, get_class($exchange));
        $this->assertEquals($expectedAmount, $exchange->from_amount);

        RateSource::unsetTestRate();
    }
}
