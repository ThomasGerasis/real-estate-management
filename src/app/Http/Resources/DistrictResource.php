<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use OpenApi\Attributes as OA;

#[OA\Schema(
    schema: 'District',
    properties: [
        new OA\Property(property: 'id', type: 'integer', example: 1),
        new OA\Property(property: 'name', type: 'string', example: 'Alfama'),
        new OA\Property(property: 'city_id', type: 'integer', example: 1),
        new OA\Property(property: 'is_active', type: 'boolean'),
        new OA\Property(property: 'image', type: 'string', format: 'uri', nullable: true),
        new OA\Property(property: 'properties_count', type: 'integer', nullable: true),
        new OA\Property(property: 'subdistricts', type: 'array', items: new OA\Items(ref: '#/components/schemas/Subdistrict'), nullable: true),
    ],
    type: 'object'
)]
class DistrictResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'postal_code' => $this->postal_code,
            'is_active' => $this->is_active,
            'image' => $this->image ? asset('storage/' . $this->image) : null,
            'city' => new CityResource($this->whenLoaded('city')),
            'subdistricts' => SubdistrictResource::collection($this->whenLoaded('subdistricts')),
            'properties_count' => $this->whenCounted('properties'),
        ];
    }
}
