<?php

namespace App\Http\Resources\Transaction\Types;

use App\Helpers\NumberFormatter;
use App\Models\Exchange;
use Illuminate\Http\Resources\Json\JsonResource;

class ExchangeResource extends JsonResource
{
    private bool $isFromCurrencyIsCrypto = false;
    private bool $isToCurrencyIsCrypto = false;

    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        /** @var Exchange $this */

        return [
            'from_amount' => NumberFormatter::formatCurrency($this->from_amount, $this->isFromCurrencyIsCrypto),
            'to_amount' => NumberFormatter::formatCurrency($this->to_amount, $this->isToCurrencyIsCrypto),
            'status_id' => $this->status_id,
            'rate' => $this->rate
        ];
    }

    public function fromCurrencyIsCrypto(bool $value = false): ExchangeResource
    {
        $this->isFromCurrencyIsCrypto = $value;

        return $this;
    }

    public function toCurrencyIsCrypto(bool $value = false): ExchangeResource
    {
        $this->isToCurrencyIsCrypto = $value;

        return $this;
    }
}
