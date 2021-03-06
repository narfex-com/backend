<?php

namespace App\Http\Requests\Webhooks\Xendit;

use App\Exceptions\Withdrawal\WithdrawalException;
use App\Services\Withdrawal\Xendit\DisbursementWebhookData;
use Illuminate\Foundation\Http\FormRequest;

class SettleDisbursementRequest extends FormRequest
{
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
        return [
            'status' => ['required', 'string'],
            'external_id' => ['required', 'string'],
            'failure_code' => ['nullable', 'string']
        ];
    }

    public function getWebhookData(): ?DisbursementWebhookData
    {
        try {
            return new DisbursementWebhookData(
                (int) $this->get('external_id'),
                $this->get('status'),
                $this->get('failure_code')
            );
        } catch (WithdrawalException $e) {
            abort(200);
        }

        return null;
    }
}
