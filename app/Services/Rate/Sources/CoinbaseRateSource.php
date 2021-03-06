<?php


namespace App\Services\Rate\Sources;


use App\Exceptions\Rate\Coinbase\CannotGetRateException;
use App\Models\Currency;
use App\Services\Rate\Directions\Direction;
use App\Services\Rate\Directions\DirectionBuy;
use App\Services\Rate\Directions\DirectionSell;
use App\Services\Rate\Rate;
use GuzzleHttp\Exception\ClientException;

class CoinbaseRateSource extends RateSource implements RateSourceInterface
{
    private bool $isExchangeRateRequested = false;

    public function getRate(Currency $asset, Currency $currency, ?Direction $direction = null): Rate
    {
        $fiatOnlyCurrencies = $asset->is_fiat && $currency->is_fiat;
        $cryptoOnlyCurrencies = !$asset->is_fiat && !$currency->is_fiat;
        if ($fiatOnlyCurrencies || $cryptoOnlyCurrencies) {
            throw new CannotGetRateException('Can not get rate if both of currencies are with same type');
        }

        if ($this->isExchangeRateRequested) {
            $direction = $asset->isFiat()
                ? new DirectionBuy()
                : new DirectionSell();
        }

        $this->asset = $asset;
        $this->currency = $currency;
        $this->direction = $direction;

        if (app()->environment() === 'testing' && self::$testRate) {
            return new Rate($this->asset, $this->currency, self::$testRate, $this->direction);
        }

        $cacheKey = "exchange_rate_{$this->asset->code}_{$this->currency->code}_{$this->direction->getDirection()}";

        $rate = $this->redis->get($cacheKey);
        if ($rate && $rate > 0) {
            return new Rate($this->asset, $this->currency, $rate, $direction);
        }

        $rate = $this->getRateFromCoinbase($this->asset, $this->currency, $this->direction);
        $this->redis->set($cacheKey, $rate);

        return new Rate($this->asset, $this->currency, $rate, $direction);
    }

    public function getExchangeRate(Currency $asset, Currency $currency): Rate
    {
        return $this->withExchangeRate()->getRate($asset, $currency);
    }

    public function getRateFromCoinbase(Currency $base, Currency $currency, Direction $direction): float
    {
        if ($base->isFiat()) {
            $tmp = $currency;
            $currency = $base;
            $base = $tmp;
        }

        $parameters = "{$base->code}-{$currency->code}/{$direction->getDirection()}";
        try {
            $response = $this->client->get("https://api.coinbase.com/v2/prices/$parameters");
            $response = json_decode($response->getBody());

            return $response->data->amount;
        } catch (ClientException $e) {
            if ($e->getCode() === 404) {
                throw new CannotGetRateException("Pair not found on coinbase: $parameters");
            }
            \Log::warning('Coinbase rate error', [$e]);
            throw new CannotGetRateException('The response from coinbase contains an error');
        }
    }

    public function withExchangeRate(): self
    {
        $this->isExchangeRateRequested = true;

        return $this;
    }
}
