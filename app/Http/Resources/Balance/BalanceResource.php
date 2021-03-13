<?php

namespace App\Http\Resources\Balance;

use App\Helpers\NumberFormatter;
use App\Http\Resources\Currency\CurrencyResource;
use App\Models\Balance;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * Class UserBalanceCollection
 * @package App\Http\Resources\Balance
 */
class BalanceResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param Request $request
     * @return array
     */
    public function toArray($request)
    {
        /** @var Balance $this */

        return [
            'id' => $this->id,
            'currency' => new CurrencyResource($this->currency),
            'amount' => NumberFormatter::formatCurrency($this->amount, $this->currency->isCrypto()),
            'address' => $this->address,
        ];
    }
}
