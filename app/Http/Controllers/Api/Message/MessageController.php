<?php

namespace App\Http\Controllers\Api\Message;

use App\Http\Requests\Api\Comment\CommentRequest;
use App\Http\Resources\CommentResource;
use App\Http\Resources\MessageResource;
use App\Models\Comment;
use App\Models\Message;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MessageController extends Controller
{
    public function index()
    {
        $user = Auth::guard('api')->user();
        $message = Message::where("to_id",$user->id)->get();
        return MessageResource::collection($message);
    }
    public function store(CommentRequest $request)
    {
        $user = Auth::guard('api')->user();
/*        $Comment = new Comment();
        $Comment->content = $request->input('content');
        $Comment->dynamic_id = $request->input('dynamic_id');
        $Comment-> user_id = $user->id;
        $Comment-> type = "dynamic";
        $Comment-> save();*/
        Comment::create([
            'content' => $request->input('content'),
            'dynamic_id' => $request->input('dynamic_id'),
            'user_id' => $user->id,
            'type' =>"dynamic",
        ]);

        return response()->json(['message' => '发布成功'], 201);
    }
    public function show(CommentRequest $request)
    {
        return (new CommentResource(Comment::find($request->id)));
    }
    public function update(CommentRequest $request)
    {
        return (new CommentResource(Comment::find($request->id)));
    }
    public function delete(CommentRequest $request)
    {
        return (new CommentResource(Comment::find($request->id)));
    }
    public function updateViewCount(CommentViewCountRequest $request)
    {
        $Comment = Comment::find($request->id);
        $Comment->view_count++;
        $Comment->save();
    }
    public function searchIndex(CommentSearchRequest $request)
    {
        // 创建一个查询构造器
        $builder = Comment::query()->where('target', 0);
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
        $Comments = $builder->withOrder($order)->paginate(10);

        return CommentResource::collection($Comments);
    }
}
