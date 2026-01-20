<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CityResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'state' => $this->state,
            'country' => $this->country,
            'postal_code' => $this->postal_code,
            'is_active' => $this->is_active,
            'districts' => DistrictResource::collection($this->whenLoaded('districts')),
            'properties_count' => $this->whenCounted('properties'),
        ];
    }
}
