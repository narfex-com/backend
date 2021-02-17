<?php

namespace App\Http\Resources\Currency;

use App\Models\Currency;
use Illuminate\Http\Resources\Json\JsonResource;

class CurrencyResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        /** @var Currency $this */
        return [
            'id' => $this->id,
            'code' => $this->code,
            'name' => $this->name,
            'is_fiat' => $this->is_fiat
        ];
    }
}
