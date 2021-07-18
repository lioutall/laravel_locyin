<?php

namespace App\Http\Requests\Api\Image;

class ImageRequest extends FormRequest
{
    public function rules()
    {
        $rules['file'] = 'required|mimes:jpeg,bmp,png,gif';
        return $rules;
    }
    public function attributes()
    {
        return [
            'file' => '文件',
        ];
    }
}
