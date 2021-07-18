<?php

namespace App\Http\Requests\Api\Dynamic;

class DynamicPublishRequest extends FormRequest
{
    public function rules()
    {
        return [
            'content' => 'required|string',
            'location' => 'required|string',
        ];
    }
    public function attributes()
    {
        return [
            'content' => '游记内容',
            'location' => '游记位置',
        ];
    }
}
