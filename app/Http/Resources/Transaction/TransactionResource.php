<?php

namespace App\Http\Resources\Transaction;

use App\Http\Resources\Transaction\Types\WithdrawalResource;
use App\Http\Resources\Transaction\Types\ExchangeResource;
use App\Http\Resources\Transaction\Types\TopupResource;
use App\Http\Resources\Balance\BalanceResource;
use App\Models\Exchange;
use App\Models\Topup;
use App\Models\Transaction;
use App\Models\Withdrawal;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Resources\Json\JsonResource;

class TransactionResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        $resource = $this->getModelResource($this->typeable);
        /** @var Transaction $this */

        return [
            'from_balance' => new BalanceResource($this->fromBalance),
            'to_balance' => new BalanceResource($this->toBalance),
            'type' => $this->typeable::TRANSACTION_TYPE,
            'model' => $resource,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }

    private function getModelResource(Model $model): ?JsonResource
    {
        switch (get_class($model)) {
            case Exchange::class:
                return (new ExchangeResource($model))
                    ->fromCurrencyIsCrypto($this->fromBalance->currency->isCrypto())
                    ->toCurrencyIsCrypto($this->toBalance->currency->isCrypto());
            case Withdrawal::class:
                return new WithdrawalResource($model);
            case Topup::class:
                return new TopupResource($model);
            default:
                return null;
        }
    }
}
