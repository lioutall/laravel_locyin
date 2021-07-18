<?php

namespace App\Http\Requests\Api\Vlog;

class VlogSearchRequest extends FormRequest
{
    public function rules()
    {
        return [
            'search' => 'required|string|max:10',
        ];
    }
}
