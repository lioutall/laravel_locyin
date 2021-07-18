<?php

namespace App\Http\Resources;

use App\Models\User;
use Illuminate\Http\Resources\Json\JsonResource;

class MessageResource extends JsonResource
{
    public function toArray($request)
    {
        if($this->from_id == 0){
            $user= User::first();
        } else{
            $user= User::where("from_id",$this->from_id)->first();
        }

        return [
            'id' => (int)$this->id,
            'vlog_id' => (int)$this->vlog_id,
            'dynamic_id' => (int)$this->dynamic_id,
            'from_id' => (int)$this->from_id,
            'from_avatar' =>(string)$user->avatar,
            'from_nickname' =>(string)$user->nickname,
            'to_id' => (int)$this->to_id,
            'push' => (int)$this->push,
            'status' => (int)$this->status,
            'type' => (string)$this->type,
            'content' => $this->content,
            'created_at' => (string) $this->created_at->format('Y-m-d'),
            'updated_at' => (string) $this->updated_at->format('Y-m-d'),
        ];
    }
}
