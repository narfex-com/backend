<?php

namespace App\Http\Requests\Auth;

use Illuminate\Foundation\Http\FormRequest;

class RegisterRequest extends FormRequest
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
            'first_name' => ['required', 'string', 'min:2', 'max:30'],
            'last_name' => ['required', 'string', 'min:2', 'max:30'],
            'email' => ['required', 'email'],
            'nickname' => ['required', 'string', ''],
            'password' => ['confirmed', 'required', 'string', 'min:8'],
        ];
    }
}
