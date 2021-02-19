<?php

namespace App\Providers;

use App\Models\Exchange;
use App\Observers\ExchangeObserver;
use App\Services\Rate\Sources\CoinbaseRateSource;
use App\Services\Rate\Sources\RateSourceInterface;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(RateSourceInterface::class, CoinbaseRateSource::class);
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Exchange::observe(ExchangeObserver::class);
    }
}
