<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ActivityResource extends JsonResource
{
    public function toArray($request): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'parent_id' => $this->parent_id,
            'level' => $this->level,
             'parent' => $this->whenLoaded('parent', fn() => new ActivityResource($this->parent)),
             'children' => ActivityResource::collection($this->whenLoaded('children')),
        ];
    }
}
