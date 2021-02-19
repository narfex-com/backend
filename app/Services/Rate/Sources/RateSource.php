<?php


namespace App\Services\Rate\Sources;


use App\Models\Currency;
use App\Services\Rate\Directions\Direction;
use GuzzleHttp\Client;
use Illuminate\Support\Facades\Redis;

class RateSource
{
    protected Currency $asset;
    protected Currency $currency;
    protected Direction $direction;

    protected Client $client;
    /** @var mixed|\Redis  */
    protected $redis;

    protected static ?float $testRate = null;

    public function __construct(Client $client)
    {
        $this->client = $client;
        $this->redis = Redis::connection()->client();
    }


    public static function setTestRate(float $rate)
    {
        if (app()->environment() !== 'testing') {
            throw new \Exception('You can not set test rate in non-testing environment');
        }

        self::$testRate = $rate;
    }

    public static function unsetTestRate()
    {
        self::$testRate = null;
    }
}
