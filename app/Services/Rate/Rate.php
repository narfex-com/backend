<?php


namespace App\Services\Rate;


use App\Exceptions\Rate\RateException;
use App\Helpers\NumberFormatter;
use App\Models\Currency;
use App\Services\Rate\Directions\Direction;
use App\Services\Rate\Directions\DirectionBuy;
use App\Services\Rate\Directions\DirectionSell;

class Rate
{
    private Currency $asset;
    private Currency $currency;
    private float $rate;
    private bool $isFeeNeeded = false;
    private Direction $direction;
    private ?float $fee = 0.04;

    /**
     * Rate constructor.
     * @param Currency $asset
     * @param Currency $currency
     * @param float $rate
     * @param Direction $direction
     */
    public function __construct(Currency $asset, Currency $currency, float $rate, Direction $direction)
    {
        $this->asset = $asset;
        $this->currency = $currency;
        $this->rate = $rate;
        $this->direction = $direction;
    }

    public function withFee(): Rate
    {
        $this->isFeeNeeded = true;

        return $this;
    }

    public function getPrice(Currency $currency, float $amount): float
    {
        if (!$currency instanceof $this->asset && !$currency instanceof $this->currency) {
            throw new RateException('Provided currency is not valid for this rate');
        }

        $rate = null;

        if ($this->asset->isCrypto()) {
            if ($currency === $this->asset) {
                $rate = $amount * $this->getRate();
            }

            if ($currency === $this->currency) {
                $rate = $this->getRate();
                $rate = $amount / $rate;
            }
        }

        if ($this->asset->isFiat()) {
            if ($currency === $this->asset) {
                $rate = $amount * $this->getRate();
            }

            if ($currency === $this->currency) {
                $rate = $amount / $this->getRate();
            }
        }

        if ($rate) {
            if ($this->asset->isCrypto() && $currency === $this->asset) {
                return NumberFormatter::formatCurrency($rate, $this->asset->isCrypto());
            }

            return $rate;
        }

        throw new RateException();
    }

    public function getRate(): float
    {
        $rate = $this->rate;

        if ($this->isFeeNeeded) {
            $rate = $this->getRateWithFee();
        }

        return (float) $this->asset->isFiat() ? 1 / $rate : $rate;
    }

    public function getRevertedRate(): float
    {
        return 1 / $this->getRate();
    }

    private function getRateWithFee(): ?float
    {
        $fee = $this->rate * $this->fee;

        if ($this->isBuyDirection()) {
            return $this->rate + $fee;
        }

        return $this->rate - $fee;
    }

    private function isBuyDirection(): bool
    {
        return $this->direction instanceof DirectionBuy;
    }
}
