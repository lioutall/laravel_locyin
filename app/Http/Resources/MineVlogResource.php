<?php

namespace App\Http\Resources;

use App\Models\Video;
use Illuminate\Http\Resources\Json\JsonResource;

class MineVlogResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id' => (int)$this->id,
            'user_id' => (int)$this->user_id,
            'thumb_count' => (int)$this->thumb_count,
            //'status' => (int)$this->status,
            'collect_count' => (int)$this->collect_count,
            'comment_count' => (int)$this->comment_count,
            'created_at' => (string) $this->created_at->format('Y-m-d'),
            'updated_at' => (string) $this->updated_at->format('Y-m-d'),
            'illustration' =>$this->illustration,
            'location' =>$this->location,
            'video' => new VideoResource($this->video),

        ];
    }
}
