<?php

namespace App\Http\Controllers\Api\Vlog;

use App\Http\Middleware\TrustHosts;
use App\Http\Requests\Api\Vlog\VlogCollectRequest;
use App\Http\Requests\Api\Vlog\VlogDeleteRequest;
use App\Http\Requests\Api\Vlog\VlogPublishRequest;
use App\Http\Requests\Api\Vlog\VlogRequest;
use App\Http\Requests\Api\Vlog\VlogSearchRequest;
use App\Http\Requests\Api\Vlog\VlogThumbRequest;
use App\Http\Requests\Api\Vlog\VlogViewCountRequest;
use App\Http\Resources\VlogResource;
use App\Http\Resources\MineVlogResource;
use App\Models\Collection;
use App\Models\Vlog;
use App\Models\Thumb;
use App\Models\Message;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class VlogsController extends Controller
{

    public function index()
    {
        $vlogs = Vlog::where('status',1)->paginate(config('api.pagination.vlog'));
        return VlogResource::collection($vlogs);
    }
    public function mine()
    {
        $user = Auth::guard('api')->user();
        $vlogs = $user->vlog;
        return MineVlogResource::collection($vlogs);
    }
    public function store(VlogPublishRequest $request)
    {
        $user = Auth::guard('api')->user();
        $vlog = new Vlog();
        $vlog->illustration = $request->input('illustration');
        $vlog->title = $request->input('title');
        $vlog->location = $request->input('location');
        $vlog-> user_id = $user->id;
        if($vlog-> save()){
            return response()->json(['message' => '发布成功'], 201);
        }
        return response()->json(['message' => '发布失败'], 500);
    }
    public function show(VlogRequest $request)
    {
        return (new VlogResource(Vlog::find($request->id)));
    }
    public function update(VlogRequest $request)
    {
        return (new VlogResource(Vlog::find($request->id)));
    }

    public function destroy(VlogDeleteRequest $request)
    {
        if(Vlog::find($request->id)->delete()){
            return response()->json(['message' => '删除成功'], 201);
        }
        return response()->json(['message' => '删除失败'], 500);

    }
    public function thumb(VlogThumbRequest $request)
    {
        $vlog = Vlog::find($request->id);
        $user = Auth::guard('api')->user();
        $vlog -> thumb_count++;
        if(Thumb::where('vlog_id' , $request->id)
            ->where( 'user_id' , $user->id)
            ->where( 'type',"vlog")->exists()){
            return response()->json(['message' => '赞过了'], 422);
        }
        Thumb::create([
            'vlog_id' => $request->id,
            'user_id' => $user->id,
            'type' => "vlog",
        ]);
        Message::create([
            'from_id' => 0,
            'to_id' => $user->id,
            'vlog_id' => $request->id,
            'type' => "vlog",
            'content' => $user->nickname."点赞了你的Vlog。",
            'status' => 0,
            'push' => 0,
        ]);
        if( $vlog->save()){
            return response()->json(['message' => '已赞'], 201);
        }
        return response()->json(['message' => '点赞失败'], 500);
    }
    public function collect(VlogCollectRequest $request)
    {
        $user = Auth::guard('api')->user();
        $vlog = Vlog::find($request->id);
        $vlog -> collect_count++;
        if(Collection::where('vlog_id' , $request->id)
            ->where( 'user_id' , $user->id)
            ->where( 'type',"vlog")->exists()){
            return response()->json(['message' => '收藏过了'], 422);
        }
        Collection::create([
            'vlog_id' => $request->id,
            'user_id' => $user->id,
            'type' => "vlog",
        ]);
        if( $vlog->save()){
            return response()->json(['message' => '收藏成功'], 201);
        }
        return response()->json(['message' => '收藏失败'], 500);

    }
    public function cancelThumb(VlogThumbRequest $request)
    {
        $vlog = Vlog::find($request->id);
        $user = Auth::guard('api')->user();
        $vlog -> thumb_count--;
        Thumb::where('vlog_id' , $request->id)
            ->where( 'user_id' , $user->id)
            ->where( 'type',"vlog")->delete();
        if( $vlog->save()){
            return response()->json(['message' => '已取消赞'], 201);
        }
        return response()->json(['message' => '取消点赞失败'], 500);
    }
    public function cancelCollect(VlogCollectRequest $request)
    {
        $user = Auth::guard('api')->user();
        $vlog = Vlog::find($request->id);
        $vlog -> collect_count--;
        Collection::where('vlog_id' , $request->id)
            ->where( 'user_id' , $user->id)
            ->where( 'type',"vlog")->delete();
        if( $vlog->save()){
            return response()->json(['message' => '取消收藏成功'], 201);
        }
        return response()->json(['message' => '取消收藏失败'], 500);

    }
    public function updateViewCount(VlogViewCountRequest $request)
    {
        $vlog = Vlog::find($request->id);
        $vlog->view_count++;
        $vlog->save();
    }
    public function searchIndex(VlogSearchRequest $request)
    {
        // 创建一个查询构造器
        $builder = Vlog::query()->where('target', 0);
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
        $vlogs = $builder->withOrder($order)->paginate(10);

        return VlogResource::collection($vlogs);
    }
}
