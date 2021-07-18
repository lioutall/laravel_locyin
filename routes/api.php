<?php

use App\Http\Controllers\Api\Comment\CommentController;
use App\Http\Controllers\Api\Comment\DcommentController;
use App\Http\Controllers\Api\Dynamic\DynamicsController;
use App\Http\Controllers\Api\Image\AvatarsController;
use App\Http\Controllers\Api\Image\ImagesController;
use App\Http\Controllers\Api\Message\MessageController;
use App\Http\Controllers\Api\User\AuthorizationsController;
use App\Http\Controllers\Api\User\CaptchasController;
use App\Http\Controllers\Api\User\UsersController;
use App\Http\Controllers\Api\User\VerificationCodesController;
use App\Http\Controllers\Api\Vlog\VlogsController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::prefix('v1')
    //命名空间
    ->namespace('Api')
    //别名
    ->name('api.v1.')
    //中间件
    ->middleware('change-locale')
    ->group(function() {
        Route::middleware('throttle:' . config('api.rate_limits.access'))->group(function () {
            Route::get('version', function () {
                return 'this is version v1';
            })->name('version');
            // 短信验证码
            //Route::post('verificationCodes', [VerificationCodesController::class, 'store']) ->name('verificationCodes.store');
            // 图片验证码
            //Route::post('captchas', [CaptchasController::class, 'store'])->name('captchas.store');
            // 用户注册
            //Route::put('users', [UsersController::class, 'store']) ->name('users.store');
            // 用户登录
            //Route::post('authorizations', [AuthorizationsController::class, 'store'])->name('authorizations.store');
            // 手机号登录短信验证码
            Route::post('loginCodes', [VerificationCodesController::class, 'sendLoginCodes']) ->name('loginByCode.sendCodes');
            // 手机号登录
            Route::post('loginByCode', [AuthorizationsController::class, 'loginByCode'])->name('loginByCode');

            //获取所有游记
            Route::get('dynamics', [DynamicsController::class, 'index']) ->name('api.dynamics.index');
            //查看游记详情
            Route::post('dynamics', [DynamicsController::class, 'show']) ->name('api.dynamics.show');
            //获取某个游记下所有评论
            Route::get('comments', [DcommentController::class, 'index']) ->name('api.comments.index');
            //查看评论详情
            Route::post('comments/detail', [DcommentController::class, 'show']) ->name('api.comments.show');
            //搜索游记
            Route::post('dynamics/search', [DynamicsController::class, 'searchIndex']) ->name('api.dynamics.search');

            //获取所有短视频
            Route::get('vlogs', [VlogsController::class, 'index']) ->name('api.vlogs.index');
            //查看短视频详情
            Route::post('vlogs', [VlogsController::class, 'show']) ->name('api.vlogs.show');
            //搜索短视频
            Route::post('vlogs/search', [VlogsController::class, 'searchIndex']) ->name('api.vlogs.search');
            // 获取其他用户的信息
            Route::post('users', [UsersController::class, 'show']) ->name('users.show');
        });
        Route::middleware('throttle:' . config('api.rate_limits.sign'))
            ->middleware('token.refresh')
            ->group(function () {
                // 刷新token
                Route::put('authorizations/current', [AuthorizationsController::class, 'update'])->name('authorizations.update');
                // 删除token
                Route::delete('authorizations/current', [AuthorizationsController::class, 'destroy'])->name('authorizations.destroy');

                // 获取登录用户的信息
                Route::get('users', [UsersController::class, 'me']) ->name('users.me');

                // 更新登录用户的信息
                Route::patch('users', [UsersController::class, 'update']) ->name('users.update');

                // 上传图片
                Route::post('images', [ImagesController::class, 'store'])
                    ->name('images.store');
                // 上传图片
                Route::post('avatars', [AvatarsController::class, 'store'])
                    ->name('avatars.store');

                /*//发布游记
                Route::put('dynamics', [DynamicsController::class, 'store']) ->name('api.dynamics.store');*/

                //删除游记
                Route::delete('dynamics', [DynamicsController::class, 'destroy']) ->name('api.dynamics.destroy');

                //我的游记
                Route::get('dynamics/mine', [DynamicsController::class, 'mine']) ->name('api.dynamics.mine');

                //更新游记
                Route::patch('dynamics', [DynamicsController::class, 'update']) ->name('api.dynamics.update');

                //删除游记
                Route::post('dynamics/delete', [DynamicsController::class, 'destroy']) ->name('api.dynamics.delete');
                //点赞游记
                Route::post('dynamics/thumb', [DynamicsController::class, 'thumb']) ->name('api.dynamics.thumb');
                //收藏游记
                Route::post('dynamics/collect', [DynamicsController::class, 'collect']) ->name('api.dynamics.collect');

                //取消点赞游记
                Route::post('dynamics/cancel_thumb', [DynamicsController::class, 'cancelThumb']) ->name('api.dynamics.cancel_thumb');

                //取消收藏游记
                Route::post('dynamics/cancel_collect', [DynamicsController::class, 'cancelCollect']) ->name('api.dynamics.cancel_collect');

                //发表评论
                Route::post('comments', [DcommentController::class, 'store']) ->name('api.comments.store');

                //发布游记
                Route::post('dynamics/publish', [DynamicsController::class, 'store']) ->name('api.dynamics.store');

                //获取所有消息
                Route::get('messages', [MessageController::class, 'index']) ->name('api.messages.index');
            });
    });
