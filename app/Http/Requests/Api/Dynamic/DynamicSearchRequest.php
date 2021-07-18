<?php

namespace App\Http\Requests\Api\Dynamic;

class DynamicSearchRequest extends FormRequest
{
    public function rules()
    {
        return [
            'search' => 'required|string|max:10',
        ];
    }
}
