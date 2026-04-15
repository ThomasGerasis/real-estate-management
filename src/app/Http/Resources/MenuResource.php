<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use OpenApi\Attributes as OA;

#[OA\Schema(
    schema: 'MenuItem',
    properties: [
        new OA\Property(property: 'id', type: 'integer'),
        new OA\Property(property: 'label', type: 'string'),
        new OA\Property(property: 'url', type: 'string', nullable: true),
        new OA\Property(property: 'icon', type: 'string', nullable: true),
        new OA\Property(property: 'sort_order', type: 'integer'),
        new OA\Property(property: 'open_in_new_tab', type: 'boolean'),
        new OA\Property(property: 'children', type: 'array', items: new OA\Items(ref: '#/components/schemas/MenuItem')),
    ],
    type: 'object'
)]
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
