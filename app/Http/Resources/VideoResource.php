<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class VideoResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id' => (int)$this->id,
            'user_id' => (int)$this->user_id,
            'vlog_id' => (int)$this->vlog_id,
            'type' =>(string)$this->type,
            'path' =>(string)$this->path,
        ];
    }
}
