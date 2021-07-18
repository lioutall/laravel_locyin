<?php

namespace App\Http\Requests\Api\Dynamic;

class DynamicCollectRequest extends FormRequest
{
    public function rules()
    {
        return [
            'id' => 'required|integer|exists:dynamics,id',
        ];
    }
}
