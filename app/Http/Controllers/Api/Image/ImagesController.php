<?php

namespace App\Http\Controllers\Api\Image;

use App\Handlers\ImageUploadHandler;
use App\Http\Requests\Api\Image\ImageRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;


class ImagesController extends Controller
{
    public function store(ImageRequest $request, ImageUploadHandler $uploader)
    {
        $user = Auth::guard('api')->user();
        $prefix = !empty($user) ? $user-> id : 'mobile';
        $result = $uploader->save_to_aliyun($request->file, Str::plural("avatar"), $prefix, null);
        if($result){
            return response()->json([
                'src' => $result['path']
            ]);
        }else{
            abort(403,'图片上传失败！');
        }
    }

}
