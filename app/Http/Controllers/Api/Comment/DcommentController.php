<?php

namespace App\Http\Controllers\Api\Comment;

use App\Http\Requests\Api\Comment\DcommentRequest;
use App\Http\Resources\DcommentResource;
use App\Models\Dcomment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DcommentController extends Controller
{
    protected $perpage = 10;
    protected $tagMaxLength = 10;

    public function index(DcommentRequest  $request)
    {
        $Dcomments = Dcomment::where('status',1)->where('dynamic_id',$request->dynamic_id)->get();
        return DcommentResource::collection($Dcomments);
    }
    public function store(DcommentRequest $request)
    {
        $user = Auth::guard('api')->user();
/*        $Dcomment = new Dcomment();
        $Dcomment->content = $request->input('content');
        $Dcomment->dynamic_id = $request->input('dynamic_id');
        $Dcomment-> user_id = $user->id;
        $Dcomment-> type = "dynamic";
        $Dcomment-> save();*/
        Dcomment::create([
            'content' => $request->input('content'),
            'dynamic_id' => $request->input('dynamic_id'),
            'user_id' => $user->id,
            'type' =>"dynamic",
        ]);

        return response()->json(['message' => '发布成功'], 201);
    }
    public function show(DcommentRequest $request)
    {
        return (new DcommentResource(Dcomment::find($request->id)));
    }
    public function update(DcommentRequest $request)
    {
        return (new DcommentResource(Dcomment::find($request->id)));
    }
    public function delete(DcommentRequest $request)
    {
        return (new DcommentResource(Dcomment::find($request->id)));
    }
}
