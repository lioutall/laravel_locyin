<?php

namespace App\Http\Requests\Api\User;

class ValidateCodeRequest extends FormRequest
{
    public function rules()
    {
        return [
            'verification_key' => 'required|string',
            'verification_code' => 'required|string',
        ];
    }
}
