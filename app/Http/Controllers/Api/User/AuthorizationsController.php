<?php

namespace App\Http\Controllers\Api\User;

use App\Http\Requests\Api\User\AuthorizationRequest;
use App\Http\Requests\Api\User\ValidateCodeRequest;
use App\Http\Resources\UserResource;
use App\Models\User;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Http\Resources\Json\JsonResource;


class AuthorizationsController extends Controller
{
    public function store(AuthorizationRequest $request)
    {
        $username = $request->username;

        if(is_mobile($username)){
            $credentials['phone'] = $username;
        }elseif (filter_var($username, FILTER_VALIDATE_EMAIL)){
            $credentials['email'] = $username;
        }else{
            $credentials['username'] = $username;
        }
        $credentials['password'] = $request->password;
        //dd($credentials);
        if (!$token = \Auth::guard('api')->attempt($credentials)) {
            throw new AuthenticationException('用户名或密码错误');
        }
        if(is_mobile($username)){
            $user = User::where('phone',$username)->first();
        }else{
            $user = User::where('username',$username)->first();
        }
        return response()->json([
            'user' => new UserResource($user),
            'access_token' => $token,
            'token_type' => 'Bearer',
            'expires_in' => auth('api')->factory()->getTTL() * 60
        ])->setStatusCode(201);
    }

    protected function respondWithToken($token)
    {
        return response()->json([
            'access_token' => $token,
            'token_type' => 'Bearer',
            'expires_in' => auth('api')->factory()->getTTL() * 60
        ]);
    }
    public function update()
    {
        $token = auth('api')->refresh();
        return $this->respondWithToken($token);
    }

    public function destroy()
    {
        auth('api')->logout();
        return response(null, 204);
    }
    public function loginByCode(ValidateCodeRequest $request){
        $verifyData = \Cache::get($request->verification_key);
        $phone = $verifyData['phone'];
        $code = $verifyData['code'];
        if (!$verifyData) {
            abort(403, '验证码已失效');
        }

        if (!hash_equals($code, $request->verification_code)) {
            throw new AuthenticationException('验证码错误');
        }
        if(!User::Where('phone',$phone)->exists()){
            User::create([
                'avatar' => "https://locyin.oss-cn-beijing.aliyuncs.com/apps/luoxun_flutter/images/avatar/logo_512x512.png",
                'nickname' => "洛寻",
                'phone' => $verifyData['phone'],
            ]);
        }
        $user = User::Where('phone',$phone)->first();
        return response()->json([
            'data' => (new UserResource($user))->showSensitiveFields(),
            'access_token' => \Auth::guard('api')->login($user),
            'token_type' => 'Bearer',
            'expires_in' => auth('api')->factory()->getTTL() * 60
        ])->setStatusCode(201);
        // 清除验证码缓存
        \Cache::forget($request->verification_key);
    }
}
