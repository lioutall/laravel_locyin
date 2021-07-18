<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ImageResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id' => (int)$this->id,
            'user_id' => (int)$this->user_id,
            'dynamic_id' => (int)$this->dynamic_id,
            'type' =>(string)$this->type,
            'path' =>(string)$this->path,
        ];
    }
}
