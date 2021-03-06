<?php

namespace App\Http\Requests\Webhooks\Xendit;

use Illuminate\Foundation\Http\FormRequest;

class SettleInvoiceRequest extends FormRequest
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
            'external_id' => ['required', 'integer'],
            'status' => ['required', 'string']
        ];
    }
}
