<?php

namespace App\Http\Resources;

use App\Models\Collection;
use App\Models\Thumb;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Resources\Json\JsonResource;
use function PHPUnit\Framework\isEmpty;

class DynamicResource extends JsonResource
{
    protected $hideUser = false;
    protected $hideComment = false;
    public function toArray($request)
    {
        $user = Auth::guard('api')->user();
        if(isEmpty ($user)){
            $user= User::first();
        }
        return [
            'id' => (int)$this->id,
            'user_id' => (int)$this->user_id,
            'thumb_count' => (int)$this->thumb_count,
            'thumbed' => (int)Thumb::where("user_id",$user->id)->where("dynamic_id",$this->id)->exists()?1:0,
            'collected' => (int)Collection::where("user_id",$user->id)->where("dynamic_id",$this->id)->exists()?1:0,
            //'status' => (int)$this->status,
            'collect_count' => (int)$this->collect_count,
            'comment_count' => (int)$this->comment_count,
            'created_at' => (string) $this->created_at->format('Y-m-d'),
            'updated_at' => (string) $this->updated_at->format('Y-m-d'),
            'content' =>$this->content,
            'location' =>$this->location,
            'user' =>   $this->hideUser ? null: new UserResource($this->user),
            //'comment' =>$this->hideComment ? null: CommentResource::collection($this->comment),
            'image' => ImageResource::collection($this->image),
        ];
    }
    public function hideUser()
    {
        $this->hideUser = true;
        return $this;
    }
    public function hideComment()
    {
        $this->hideComment = true;
        return $this;
    }
}
