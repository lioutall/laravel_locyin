<?php

namespace App\Http\Requests\Api\Vlog;

class VlogPublishRequest extends FormRequest
{
    public function rules()
    {
        return[
            'path' => 'required|string',
            'illustration' => 'required|string',
            'location' => 'required|string',
        ];
    }
    public function attributes()
    {
        return [
            'path' => '短视频地址',
            'illustration' => '短视频说明',
            'location' => '短视频位置',
        ];
    }
}
