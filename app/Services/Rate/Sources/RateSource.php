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

    public function __construct(Client $client)
    {
        $this->client = $client;
        $this->redis = Redis::connection()->client();
    }
}
