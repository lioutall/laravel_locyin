<?php

namespace App\Http\Requests\Api\Dynamic;

class DynamicRequest extends FormRequest
{
    public function rules()
    {
        switch($this->method()) {
            case 'PUT':
                return [
                    'content' => 'required|string',
                ];break;
            case 'POST':
                return [
                    'id' => 'required|integer|exists:dynamics,id',
                ];break;
            case 'DELETE':
                return [
                    'id' => 'required|integer|exists:dynamics,id',
                ];break;
            default:break;
        }
    }
    public function attributes()
    {
        return [
            'content' => '游记内容',
        ];
    }
}
