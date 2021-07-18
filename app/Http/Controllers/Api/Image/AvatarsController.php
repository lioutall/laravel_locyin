<?php

namespace App\Http\Controllers\Api\Image;

use App\Handlers\ImageUploadHandler;
use App\Http\Requests\Api\Image\AvatarRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;


class AvatarsController extends Controller
{
    public function store(AvatarRequest $request, ImageUploadHandler $uploader)
    {
        $user = Auth::guard('api')->user();
        $prefix = !empty($user) ? $user-> id : 'mobile';
        $size = 300;
        $result = $uploader->save_to_aliyun($request->file, Str::plural("dynamic"), $prefix, $size);
        if($result){
            $user->avatar = $result['path'];
            $user->save();
            return response()->json([
                'src' => $result['path']
            ]);
        }else{
            abort(403,'图片上传失败！');
        }
    }

}
