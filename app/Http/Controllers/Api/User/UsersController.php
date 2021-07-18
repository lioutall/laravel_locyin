<?php

namespace App\Http\Controllers\Api\User;

use App\Http\Requests\Api\User\RegisterRequest;
use App\Http\Requests\Api\User\ValidateCodeRequest;
use App\Http\Requests\Api\User\UserRequest;
use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Resources\UserResource;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Overtrue\EasySms\EasySms;
class UsersController extends Controller
{
    public function store(RegisterRequest $request)
    {
        $verifyData = \Cache::get($request->verification_key);

        if (!$verifyData) {
            abort(403, '验证码已失效');
        }

        if (!hash_equals($verifyData['code'], $request->verification_code)) {
            // 返回401
            throw new AuthenticationException('验证码错误');
        }

        $user = User::create([
            'username' => $request->username,
            'nickname' => $request->username,
            'phone' => $verifyData['phone'],
            'password' => bcrypt($request->password),
        ]);

        // 清除验证码缓存
        \Cache::forget($request->verification_key);

        return new UserResource($user);
    }
    public function me(Request $request)
    {
        return (new UserResource(Auth::guard('api')->user()))->showSensitiveFields();
    }
    public function show(UserRequest $request)
    {
        return (new UserResource(User::find($request->id)));
    }
    public function update(UserRequest $request)
    {
        $user = \Auth::guard('api')->user();
        $attributes = $request->only(['nickname', 'introduction']);

        if ($request->avatar) {
            $attributes['avatar'] = $request->avatar;
        }
        $user->update($attributes);

    }

    public function resetPassword(ValidateCodeRequest $request)
    {
        $user = User::find($request->user_id);

        $verifyData = \Cache::get($request->verification_key);

        if (!$verifyData) {
            abort(403, '验证码已失效');
        }

        if (!hash_equals($verifyData['code'], $request->verification_code)) {
            // 返回401
            throw new AuthenticationException('验证码错误');
        }
        $attributes['password'] = bcrypt($request->password);

        $user->update($attributes);
        // 清除验证码缓存
        \Cache::forget($request->verification_key);

        return new UserResource($user);

    }

}
