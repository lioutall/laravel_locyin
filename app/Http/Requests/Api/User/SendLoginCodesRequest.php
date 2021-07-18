<?php

namespace App\Http\Requests\Api\User;

class SendLoginCodesRequest extends FormRequest
{
    public function rules()
    {
        return [
            'phone' => 'required|phone:CN,mobile',
        ];
    }
}
