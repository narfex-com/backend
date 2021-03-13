<?php

namespace App\Http\Requests\Withdrawal;

use App\DTOs\Withdrawal\CreateWithdrawalDTO;
use App\Exceptions\Withdrawal\CurrencyNotSupportedException;
use App\Http\Responses\JsonResponse;
use App\Models\Balance;
use App\Services\Withdrawal\WithdrawalProcessManager;
use Illuminate\Foundation\Http\FormRequest;

class CreateWithdrawalRequest extends FormRequest
{
    private ?Balance $balance = null;

    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $validation = [
            'balance_id' => ['required', 'integer'],
            'amount' => ['required', 'numeric'],
        ];

        $this->balance = Balance::whereUserId($this->user()->id)
            ->whereId($this->get('balance_id'))
            ->firstOrFail();

        $currency = $this->balance->currency;

        $processManager = app(WithdrawalProcessManager::class);
        try {
            $additionalRules = $processManager->make($currency)->getAdditionalValidationRules();
        } catch (CurrencyNotSupportedException $e) {
            $response = app(JsonResponse::class);
            return $response->withErrorCode('currency_not_supported')->build();
        }

        return array_merge($validation, $additionalRules);
    }

    public function getDto(): CreateWithdrawalDTO
    {
        return new CreateWithdrawalDTO($this->balance, $this->get('amount'), $this);
    }
}
