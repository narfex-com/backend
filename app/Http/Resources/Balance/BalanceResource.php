<?php

namespace App\Http\Resources\Balance;

use App\Http\Resources\Currency\CurrencyResource;
use App\Models\Balance;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * Class BalanceCollection
 * @package App\Http\Resources\Balance
 */
class BalanceResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        /** @var Balance $this */
        return [
            'id' => $this->id,
            'currency' => new CurrencyResource($this->currency),
            'amount' => $this->amount,
            'address' => $this->address,
        ];
    }
}
