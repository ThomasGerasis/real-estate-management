<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use OpenApi\Attributes as OA;

#[OA\Schema(
    schema: 'City',
    properties: [
        new OA\Property(property: 'id', type: 'integer', example: 1),
        new OA\Property(property: 'name', type: 'string', example: 'Lisbon'),
        new OA\Property(property: 'state', type: 'string', nullable: true, example: 'Lisboa'),
        new OA\Property(property: 'country', type: 'string', nullable: true, example: 'Portugal'),
        new OA\Property(property: 'postal_code', type: 'string', nullable: true),
        new OA\Property(property: 'featured_image', type: 'string', format: 'uri', nullable: true),
        new OA\Property(property: 'is_active', type: 'boolean'),
        new OA\Property(property: 'properties_count', type: 'integer', nullable: true),
        new OA\Property(property: 'districts', type: 'array', items: new OA\Items(ref: '#/components/schemas/District')),
    ],
    type: 'object'
)]
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
            'featured_image' => $this->image ? asset('storage/' . $this->image) : null,
            'is_active' => $this->is_active,
            'districts' => DistrictResource::collection($this->whenLoaded('districts')),
            'properties_count' => $this->whenCounted('properties'),
        ];
    }
}
