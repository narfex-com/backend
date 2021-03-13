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
    private bool $isLiveRate = false;

    public function getRate(Currency $asset, Currency $currency, ?Direction $direction = null): Rate
    {
        if ($asset->hasSameType($currency)) {
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

        $rate = $this->getRateFromCoinbase($this->asset, $this->currency, $this->direction);

        return new Rate($this->asset, $this->currency, $rate, $direction);
    }

    public function getExchangeRate(Currency $asset, Currency $currency, bool $isLiveRate = false): Rate
    {
        $this->isLiveRate = $isLiveRate;
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

    public function getRatesByCurrency(Currency $currency): array
    {
        $response = $this->client->get("https://api.coinbase.com/v2/exchange-rates/?currency={$currency->code}");
        return (array) json_decode($response->getBody())->data->rates;
    }
}
