<?php

namespace App\Http\Requests\Api\Dynamic;

class DynamicDeleteRequest extends FormRequest
{
    public function rules()
    {
        return [
            'id' => 'required|integer|exists:dynamics,id',
        ];
    }
}
