<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use OpenApi\Attributes as OA;

#[OA\Schema(
    schema: 'Subdistrict',
    properties: [
        new OA\Property(property: 'id', type: 'integer', example: 1),
        new OA\Property(property: 'name', type: 'string', example: 'Kolonaki'),
        new OA\Property(property: 'district_id', type: 'integer', example: 1),
        new OA\Property(property: 'postal_code', type: 'string', nullable: true),
        new OA\Property(property: 'is_active', type: 'boolean'),
        new OA\Property(property: 'properties_count', type: 'integer', nullable: true),
    ],
    type: 'object'
)]
class SubdistrictResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'district_id' => $this->district_id,
            'postal_code' => $this->postal_code,
            'is_active' => $this->is_active,
            'district' => new DistrictResource($this->whenLoaded('district')),
            'properties_count' => $this->whenCounted('properties'),
        ];
    }
}
