<?php

namespace App\Console\Commands\Rates;

use App\Models\Currency;
use App\Services\Rate\RateService;
use GuzzleHttp\Client;
use Illuminate\Console\Command;
use Spatie\Async\Pool;

class UpdateRates extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'rates:update {--once}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Updates rates in redis';

    private RateService $rateService;

    /**
     * Create a new command instance.
     *
     * @param RateService $rateService
     */
    public function __construct(RateService $rateService)
    {
        $this->rateService = $rateService;

        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle(): int
    {
        $isOnce = (bool) $this->option('once');

        while (true) {
            $currencies = Currency::available()->get();

            $pool = Pool::create();
            $pool->concurrency(20);
            $httpClient = new Client();
            $rateService = app()->make(RateService::class);

            foreach ($currencies as $baseCurrency) {
                $neededCurrencies = $currencies->filter(fn(Currency $currency) => $baseCurrency->code !== $currency->code);

                foreach ($neededCurrencies as $neededCurrency) {
                    if ($baseCurrency->hasSameType($neededCurrency)) continue;

                    $pool[] = async(function() use ($baseCurrency, $neededCurrency, $rateService, $httpClient){
                        $cacheKey = "exchange_rate_{$baseCurrency->code}-{$neededCurrency->code}";

                        $rate = $rateService->getExchangeRate($baseCurrency, $neededCurrency)->getRate();

                        return [$cacheKey, $rate];
                    })->then(function (array $rate) use (&$queryCount){
                        $queryCount += 1;
                        $this->info("{$rate[0]}: $rate[1]");
                        \Cache::set($rate[0], $rate[1]);
                    });
                }
            }

            await($pool);

            if ($isOnce) {
                break;
            }
        }
        return 0;
    }
}
