<?php


namespace App\Services\Rate\Sources;


use App\Exceptions\Rate\Coinbase\CannotGetRateException;
use App\Models\Currency;
use App\Services\Rate\Directions\Direction;
use App\Services\Rate\Rate;
use GuzzleHttp\Exception\ClientException;
use GuzzleHttp\Exception\GuzzleException;

class CoinbaseRateSource extends RateSource implements RateSourceInterface
{
    public function getRate(Currency $asset, Currency $currency, Direction $direction): Rate
    {
        $fiatOnlyCurrencies = $asset->is_fiat && $currency->is_fiat;
        $cryptoOnlyCurrencies = !$asset->is_fiat && !$currency->is_fiat;
        if ($fiatOnlyCurrencies || $cryptoOnlyCurrencies) {
            throw new CannotGetRateException('Can not get rate if both of currencies are with same type');
        }

        $this->asset = $asset;
        $this->currency = $currency;
        $this->direction = $direction;

        $cacheKey = 'exchange_rate_' . $asset->code . '_' . $currency->code;

        $rate = $this->redis->get($cacheKey);
        if ($rate && $rate > 0) {
            return new Rate($this->asset, $this->currency, $rate, $direction);
        }

        $rate = $this->getRateFromCoinbase();
        $this->redis->set($cacheKey, $rate);

        return new Rate($this->asset, $this->currency, $rate, $direction);
    }

    private function getRateFromCoinbase(): float
    {
        $base = $this->asset;
        $currency = $this->currency;
        $needSwitchCurrencies = false;

        if ($base->is_fiat) {
            $needSwitchCurrencies = true;
            $currency = $base;
            $base = $this->currency;
        }
        $parameters = "{$base->code}-{$currency->code}/{$this->direction->getDirection()}";
        try {
            $response = $this->client->get("https://api.coinbase.com/v2/prices/$parameters");
            $response = json_decode($response->getBody());

            $rate = $response->data->amount;
            if ($needSwitchCurrencies) {
                $rate = 1/$rate;
            }

            return $rate;
        } catch (ClientException $e) {
            if ($e->getCode() === 404) {
                throw new CannotGetRateException("Pair not found on coinbase: $parameters");
            }
            \Log::warning('Coinbase rate error', [$e]);
            throw new CannotGetRateException('The response from coinbase contains an error');
        }
    }
}
