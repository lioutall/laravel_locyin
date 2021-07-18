<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class DcommentResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id' => (int)$this->id,
            'user_id' => (int)$this->user_id,
            'dynamic_id' => (int)$this->dynamic_id,
            //'video_id' => (int)$this->video_id,
            'thumb_count' => (int)$this->thumb_count,
            //'type' => (string)$this->type,
            'content' => $this->content,
            'created_at' => (string) $this->created_at->format('Y-m-d'),
            'updated_at' => (string) $this->updated_at->format('Y-m-d'),
            'user' => new UserResource($this->user),
        ];
    }
}
