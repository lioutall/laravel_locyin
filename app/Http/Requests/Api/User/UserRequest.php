<?php

namespace App\Http\Requests\Api\User;

class UserRequest extends FormRequest
{
    public function rules()
    {
        switch($this->method()) {
            case 'PUT':
                return [
                    'username' => 'required|between:6,10|regex:/^[A-Za-z0-9\-\_]+$/',
                    'password' => 'required|alpha_dash|min:6',
                    'verification_key' => 'required|string',
                    'verification_code' => 'required|string',
                ];
                break;
            case 'POST':
                return [
                    'id' => 'required|integer|exists:users,id',
                ];
                break;
            case 'PATCH':
                return [
                    'nickname' => 'required|string|max:30',
                    'introduction' => 'required|string|max:150',
                    'avatar' => 'nullable|string',
                ];
                break;
        }

    }

    public function attributes()
    {
        return [
            'username' => '用户名',
            'nickname' => '昵称',
            'introduction' => '自我介绍',
            'avatar' => '头像',
        ];
    }
}
