<?php

namespace App\Http\Requests\Api\Vlog;

class VlogRequest extends FormRequest
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
                    'id' => 'required|integer|exists:vlogs,id',
                ];break;
            case 'DELETE':
                return [
                    'id' => 'required|integer|exists:vlogs,id',
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
