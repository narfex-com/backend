<?php

namespace App\Http\Requests\Exchange;

use Illuminate\Foundation\Http\FormRequest;

class CreateExchangeRequest extends FormRequest
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
            'from_balance_id' => ['required', 'integer'],
            'to_balance_id' => ['required', 'integer'],
            'from_amount' => ['required', 'numeric'],
            'to_amount' => ['required', 'numeric'],
            'is_from_amount' => ['required', 'boolean']
        ];
    }
}
