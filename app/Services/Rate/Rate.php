<?php


namespace App\Services\Rate;


use App\Models\Currency;
use App\Services\Rate\Directions\Direction;
use App\Services\Rate\Directions\DirectionBuy;

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

    public function getPrice(float $amount): float
    {
        return $amount / $this->rate;
    }

    public function getPriceWithFee(float $amount): float
    {
        $rate = $this->getRateWithFee();
        return $amount / $rate;
    }

    public function getRate(): float
    {
        return $this->rate;
    }

    public function getRevertedRate(): Rate
    {
        $rate = 1 / $this->rate;
        return new self($this->currency, $this->asset, $rate, new DirectionBuy());
    }

    private function getRateWithFee(): ?float
    {
        if ($this->isFeeNeeded) {
            $fee = $this->rate * $this->fee;
            if ($this->isBuyDirection()) {
                return $this->rate + $fee;
            } else {
                return $this->rate - $fee;
            }
        }

        return null;
    }

    private function isBuyDirection(): bool
    {
        return get_class($this->direction) === DirectionBuy::class;
    }
}
