<?php

namespace App\Http\Requests\Api\Vlog;

class VlogViewCountRequest extends FormRequest
{
    public function rules()
    {
        return [
            'id' => 'required|integer|exists:vlogs,id',
        ];
    }
}
