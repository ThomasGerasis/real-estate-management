<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

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
