<?php

namespace App\Http\Controllers\Api\Dynamic;

use App\Http\Middleware\TrustHosts;
use App\Http\Requests\Api\Dynamic\DynamicCollectRequest;
use App\Http\Requests\Api\Dynamic\DynamicDeleteRequest;
use App\Http\Requests\Api\Dynamic\DynamicPublishRequest;
use App\Http\Requests\Api\Dynamic\DynamicRequest;
use App\Http\Requests\Api\Dynamic\DynamicSearchRequest;
use App\Http\Requests\Api\Dynamic\DynamicThumbRequest;
use App\Http\Requests\Api\Dynamic\DynamicViewCountRequest;
use App\Http\Resources\DynamicResource;
use App\Http\Resources\MineDynamicResource;
use App\Models\Collection;
use App\Models\Dynamic;
use App\Models\Thumb;
use App\Models\Message;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DynamicsController extends Controller
{

    public function index()
    {
        $dynamics = Dynamic::where('status',1)->paginate(config('api.pagination.dynamic'));
        return DynamicResource::collection($dynamics);
    }
    public function mine()
    {
        $user = Auth::guard('api')->user();
        $dynamics = $user->dynamic;
        return MineDynamicResource::collection($dynamics);
    }
    public function store(DynamicPublishRequest $request)
    {
        $user = Auth::guard('api')->user();
        $dynamic = new Dynamic();
        $dynamic->content = $request->input('content');
        $dynamic->location = $request->input('location');
        $dynamic-> user_id = $user->id;
        if($dynamic-> save()){
            return response()->json(['message' => '发布成功'], 201);
        }
        return response()->json(['message' => '发布失败'], 500);
    }
    public function show(DynamicRequest $request)
    {
        return (new DynamicResource(Dynamic::find($request->id)));
    }
    public function update(DynamicRequest $request)
    {
        return (new DynamicResource(Dynamic::find($request->id)));
    }

    public function destroy(DynamicDeleteRequest $request)
    {
        if(Dynamic::find($request->id)->delete()){
            return response()->json(['message' => '删除成功'], 201);
        }
        return response()->json(['message' => '删除失败'], 500);

    }
    public function thumb(DynamicThumbRequest $request)
    {
        $dynamic = Dynamic::find($request->id);
        $user = Auth::guard('api')->user();
        $dynamic -> thumb_count++;
        if(Thumb::where('dynamic_id' , $request->id)
            ->where( 'user_id' , $user->id)
            ->where( 'type',"dynamic")->exists()){
            return response()->json(['message' => '赞过了'], 422);
        }
        Thumb::create([
            'dynamic_id' => $request->id,
            'user_id' => $user->id,
            'type' => "dynamic",
        ]);
        Message::create([
            'from_id' => 0,
            'to_id' => $user->id,
            'dynamic_id' => $request->id,
            'type' => "dynamic",
            'content' => "系统消息：".$user->nickname."点赞了你的游记。",
            'status' => 0,
            'push' => 0,
        ]);
        if( $dynamic->save()){
            return response()->json(['message' => '已赞'], 201);
        }
        return response()->json(['message' => '点赞失败'], 500);
    }
    public function collect(DynamicCollectRequest $request)
    {
        $user = Auth::guard('api')->user();
        $dynamic = Dynamic::find($request->id);
        $dynamic -> collect_count++;
        if(Collection::where('dynamic_id' , $request->id)
            ->where( 'user_id' , $user->id)
            ->where( 'type',"dynamic")->exists()){
            return response()->json(['message' => '收藏过了'], 422);
        }
        Collection::create([
            'dynamic_id' => $request->id,
            'user_id' => $user->id,
            'type' => "dynamic",
        ]);
        if( $dynamic->save()){
            return response()->json(['message' => '收藏成功'], 201);
        }
        return response()->json(['message' => '收藏失败'], 500);

    }
    public function cancelThumb(DynamicThumbRequest $request)
    {
        $dynamic = Dynamic::find($request->id);
        $user = Auth::guard('api')->user();
        $dynamic -> thumb_count--;
        Thumb::where('dynamic_id' , $request->id)
            ->where( 'user_id' , $user->id)
            ->where( 'type',"dynamic")->delete();
        if( $dynamic->save()){
            return response()->json(['message' => '已取消赞'], 201);
        }
        return response()->json(['message' => '取消点赞失败'], 500);
    }
    public function cancelCollect(DynamicCollectRequest $request)
    {
        $user = Auth::guard('api')->user();
        $dynamic = Dynamic::find($request->id);
        $dynamic -> collect_count--;
        Collection::where('dynamic_id' , $request->id)
            ->where( 'user_id' , $user->id)
            ->where( 'type',"dynamic")->delete();
        if( $dynamic->save()){
            return response()->json(['message' => '取消收藏成功'], 201);
        }
        return response()->json(['message' => '取消收藏失败'], 500);

    }
    public function updateViewCount(DynamicViewCountRequest $request)
    {
        $dynamic = Dynamic::find($request->id);
        $dynamic->view_count++;
        $dynamic->save();
    }
    public function searchIndex(DynamicSearchRequest $request)
    {
        // 创建一个查询构造器
        $builder = Dynamic::query()->where('target', 0);
        // 判断是否有提交 search 参数，如果有就赋值给 $search 变量
        // search 参数用来模糊搜索商品
        if ($search = $request->search) {
            $like = '%'.$search.'%';
            // 模糊搜索商品标题、商品详情、SKU 标题、SKU描述
            $builder->where(function ($query) use ($like) {
                $query->where('title', 'like', $like)
                    ->orWhere('excerpt', 'like', $like);
            });
        }

        // 是否有提交 order 参数，如果有就赋值给 $order 变量
        // order 参数用来控制商品的排序规则
//        if ($order = $request->input('order', '')) {
//            // 是否是以 _asc 或者 _desc 结尾
//            if (preg_match('/^(.+)_(asc|desc)$/', $order, $m)) {
//                // 如果字符串的开头是这 3 个字符串之一，说明是一个合法的排序值
//                if (in_array($m[1], ['reply_count', 'view_count'])) {
//                    // 根据传入的排序值来构造排序参数
//                    $builder->orderBy($m[1], $m[2]);
//                }
//            }
//        }
        $order = '';
        $dynamics = $builder->withOrder($order)->paginate(10);

        return DynamicResource::collection($dynamics);
    }
}
