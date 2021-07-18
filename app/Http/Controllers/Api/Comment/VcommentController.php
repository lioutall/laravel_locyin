<?php

namespace App\Http\Controllers\Api\Comment;

use App\Http\Requests\Api\Comment\VcommentRequest;
use App\Http\Resources\VcommentResource;
use App\Models\Vcomment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class VcommentController extends Controller
{
    protected $perpage = 10;
    protected $tagMaxLength = 10;

    public function index(VcommentRequest  $request)
    {
        $Vcomments = Vcomment::where('status',1)->where('dynamic_id',$request->dynamic_id)->get();
        return VcommentResource::collection($Vcomments);
    }
    public function store(VcommentRequest $request)
    {
        $user = Auth::guard('api')->user();
/*        $Vcomment = new Vcomment();
        $Vcomment->content = $request->input('content');
        $Vcomment->dynamic_id = $request->input('dynamic_id');
        $Vcomment-> user_id = $user->id;
        $Vcomment-> type = "dynamic";
        $Vcomment-> save();*/
        Vcomment::create([
            'content' => $request->input('content'),
            'dynamic_id' => $request->input('dynamic_id'),
            'user_id' => $user->id,
            'type' =>"dynamic",
        ]);

        return response()->json(['message' => '发布成功'], 201);
    }
    public function show(VcommentRequest $request)
    {
        return (new VcommentResource(Vcomment::find($request->id)));
    }
    public function update(VcommentRequest $request)
    {
        return (new VcommentResource(Vcomment::find($request->id)));
    }
    public function delete(VcommentRequest $request)
    {
        return (new VcommentResource(Vcomment::find($request->id)));
    }
}
