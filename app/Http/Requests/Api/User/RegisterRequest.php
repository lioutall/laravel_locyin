<?php

namespace App\Http\Requests\Api\User;

class RegisterRequest extends FormRequest
{
    public function rules()
    {
        return [
            'username' => 'required|between:6,10|regex:/^[A-Za-z0-9\-\_]+$/|unique:users',
            'password' => 'required|alpha_dash|min:6',
            'verification_key' => 'required|string',
            'verification_code' => 'required|string',
        ];

    }
    public function attributes()
    {
        return [
            'username' => '用户名',
            'verification_code' => '验证码',
        ];
    }
}
