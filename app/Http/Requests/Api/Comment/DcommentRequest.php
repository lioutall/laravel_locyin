<?php

namespace App\Http\Requests\Api\Comment;

class DcommentRequest extends FormRequest
{
    public function rules()
    {
        switch($this->method()) {
            case 'GET':
                return [
                    'dynamic_id' => 'required|integer|exists:dynamics,id',
                ];break;
            case 'PUT':
                return [
                    'content' => 'required|string',
                    'dynamic_id' => 'required|integer|exists:dynamics,id',
                ];break;
            case 'POST':
                return [
                    'content' => 'required|string',
                    'dynamic_id' => 'required|integer|exists:dynamics,id',
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
