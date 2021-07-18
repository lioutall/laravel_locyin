<?php

namespace App\Http\Requests\Api\Image;

class AvatarRequest extends FormRequest
{
    public function rules()
    {
        $rules['file'] = 'required|mimes:jpeg,jpg,bmp,png|dimensions:min_width=200,min_height=200';
        return $rules;
    }
    public function attributes()
    {
        return [
            'file' => '文件',
        ];
    }
    public function messages()
    {
        return [
            'file.dimensions' => '图片的清晰度不够，宽和高需要 200px 以上',
        ];
    }
}
