<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class MenuResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'label' => $this->label,
            'url' => $this->url,
            'icon' => $this->icon,
            'sort_order' => $this->sort_order,
            'open_in_new_tab' => $this->open_in_new_tab,
            'children' => MenuResource::collection($this->whenLoaded('children')),
        ];
    }
}
