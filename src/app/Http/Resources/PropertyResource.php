<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use OpenApi\Attributes as OA;

#[OA\Schema(
    schema: 'Property',
    properties: [
        new OA\Property(property: 'id', type: 'integer', example: 1),
        new OA\Property(property: 'title', type: 'string', example: 'Modern apartment in Lisbon'),
        new OA\Property(property: 'slug', type: 'string', example: 'modern-apartment-in-lisbon'),
        new OA\Property(property: 'description', type: 'string', nullable: true),
        new OA\Property(property: 'type', type: 'string', enum: ['house', 'apartment', 'commercial', 'land'], example: 'apartment'),
        new OA\Property(property: 'listing_type', type: 'string', enum: ['sale', 'rent'], example: 'sale'),
        new OA\Property(property: 'status', type: 'string', enum: ['available', 'sold', 'rented', 'reserved'], example: 'available'),
        new OA\Property(property: 'price', type: 'number', format: 'float', example: 250000),
        new OA\Property(property: 'price_formatted', type: 'string', example: '€250,000'),
        new OA\Property(property: 'bedrooms', type: 'integer', nullable: true, example: 3),
        new OA\Property(property: 'bathrooms', type: 'integer', nullable: true, example: 2),
        new OA\Property(property: 'square_meters', type: 'number', format: 'float', nullable: true, example: 120.5),
        new OA\Property(property: 'year_built', type: 'integer', nullable: true, example: 2010),
        new OA\Property(property: 'energy_class', type: 'string', nullable: true, example: 'A'),
        new OA\Property(property: 'garage', type: 'boolean', nullable: true),
        new OA\Property(property: 'address', type: 'string', nullable: true),
        new OA\Property(property: 'postal_code', type: 'string', nullable: true),
        new OA\Property(property: 'featured_image', type: 'string', format: 'uri', nullable: true),
        new OA\Property(property: 'images', type: 'array', items: new OA\Items(type: 'string', format: 'uri')),
        new OA\Property(property: 'extra_details', type: 'object'),
        new OA\Property(property: 'is_featured', type: 'boolean'),
        new OA\Property(property: 'published_at', type: 'string', format: 'date-time', nullable: true),
        new OA\Property(property: 'city', ref: '#/components/schemas/City', nullable: true),
        new OA\Property(property: 'district', ref: '#/components/schemas/District', nullable: true),
        new OA\Property(property: 'agent', ref: '#/components/schemas/Agent', nullable: true),
        new OA\Property(property: 'seo', ref: '#/components/schemas/Seo'),
        new OA\Property(property: 'created_at', type: 'string', format: 'date-time'),
        new OA\Property(property: 'updated_at', type: 'string', format: 'date-time'),
    ],
    type: 'object'
)]
class PropertyResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'title' => $this->title,
            'slug' => \Illuminate\Support\Str::slug($this->title),
            'description' => $this->description,
            'type' => $this->type,
            'listing_type' => $this->listing_type,
            'status' => $this->status,
            'price' => $this->price,
            'price_formatted' => $this->listing_type === 'rent' 
                ? '€' . number_format($this->price, 0) . '/month'
                : '€' . number_format($this->price, 0),
            'bedrooms' => $this->bedrooms,
            'bathrooms' => $this->bathrooms,
            'square_meters' => $this->square_meters,
            'year_built' => $this->year_built,
            'energy_class' => $this->energy_class,
            'garage' => $this->garage,
            'address' => $this->address,
            'postal_code' => $this->postal_code,
            'featured_image' => $this->featured_image ? asset('storage/' . $this->featured_image) : null,
            'images' => $this->images ? array_map(function($image) {
                return asset('storage/' . $image);
            }, $this->images) : [],
            'extra_details' => $this->extra_details ?? [],
            'is_featured' => $this->is_featured,
            'published_at' => $this->published_at?->toIso8601String(),
            
            // Relationships
            'city' => $this->whenLoaded('city', function() {
                return new CityResource($this->city);
            }),
            'district' => $this->whenLoaded('district', function() {
                return new DistrictResource($this->district);
            }),
            'agent' => $this->whenLoaded('agent', function() {
                return new AgentResource($this->agent);
            }),
            
            // SEO
            'seo' => [
                'title' => $this->meta_title ?? $this->auto_meta_title,
                'description' => $this->meta_description ?? $this->auto_meta_description,
            ],
            
            // Timestamps
            'created_at' => $this->created_at->toIso8601String(),
            'updated_at' => $this->updated_at->toIso8601String(),
        ];
    }
}
