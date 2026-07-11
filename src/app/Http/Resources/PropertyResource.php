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
        new OA\Property(property: 'publish_status', type: 'string', enum: ['draft', 'published'], example: 'published'),
        new OA\Property(property: 'price', type: 'number', format: 'float', example: 250000),
        new OA\Property(property: 'price_formatted', type: 'string', example: '€250,000'),
        new OA\Property(property: 'bedrooms', type: 'integer', nullable: true, example: 3),
        new OA\Property(property: 'bathrooms', type: 'integer', nullable: true, example: 2),
        new OA\Property(property: 'square_meters', type: 'number', format: 'float', nullable: true, example: 120.5),
        new OA\Property(property: 'year_built', type: 'integer', nullable: true, example: 2010),
        new OA\Property(property: 'energy_class', type: 'string', nullable: true, example: 'A'),
        new OA\Property(property: 'garage', type: 'integer', nullable: true),
        new OA\Property(property: 'garage_type', type: 'string', nullable: true),
        new OA\Property(property: 'elevator', type: 'boolean', nullable: true),
        new OA\Property(property: 'heating_type', type: 'string', nullable: true),
        new OA\Property(property: 'heating_fuel', type: 'string', nullable: true),
        new OA\Property(property: 'fireplace', type: 'boolean', nullable: true),
        new OA\Property(property: 'furnished', type: 'boolean', nullable: true),
        new OA\Property(property: 'property_position', type: 'string', nullable: true),
        new OA\Property(property: 'property_condition', type: 'string', nullable: true),
        new OA\Property(property: 'floor_type', type: 'string', nullable: true),
        new OA\Property(property: 'floor', type: 'integer', nullable: true, example: 3),
        new OA\Property(property: 'latitude', type: 'number', format: 'float', nullable: true, example: 37.9838),
        new OA\Property(property: 'longitude', type: 'number', format: 'float', nullable: true, example: 23.7275),
        new OA\Property(property: 'featured_image', type: 'string', format: 'uri', nullable: true),
        new OA\Property(property: 'images', type: 'array', items: new OA\Items(type: 'string', format: 'uri')),
        new OA\Property(property: 'extra_details', type: 'object'),
        new OA\Property(property: 'is_featured', type: 'boolean'),
        new OA\Property(property: 'published_at', type: 'string', format: 'date-time', nullable: true),
        new OA\Property(property: 'city', ref: '#/components/schemas/City', nullable: true),
        new OA\Property(property: 'district', ref: '#/components/schemas/District', nullable: true),
        new OA\Property(property: 'subdistrict', ref: '#/components/schemas/Subdistrict', nullable: true),
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
            'title' => self::cleanUtf8($this->title),
            'slug' => \Illuminate\Support\Str::slug($this->title),
            'description' => self::cleanUtf8($this->description),
            'type' => $this->type,
            'listing_type' => $this->listing_type,
            'status' => $this->status,
            'publish_status' => $this->publish_status,
            'price' => $this->price,
            'price_formatted' => '€' . number_format($this->price, 0),
            'bedrooms' => $this->bedrooms,
            'bathrooms' => $this->bathrooms,
            'square_meters' => $this->square_meters,
            'year_built' => $this->year_built,
            'energy_class' => $this->energy_class,
            'garage' => $this->garage,
            'garage_type' => $this->garage_type,
            'elevator' => $this->elevator,
            'heating_type' => $this->heating_type,
            'heating_fuel' => $this->heating_fuel,
            'fireplace' => $this->fireplace,
            'furnished' => $this->furnished,
            'property_position' => $this->property_position,
            'property_condition' => $this->property_condition,
            'floor_type' => self::cleanUtf8($this->floor_type),
            'floor' => $this->floor,
            'latitude' => $this->latitude ? (float) $this->latitude : null,
            'longitude' => $this->longitude ? (float) $this->longitude : null,
            'featured_image' => $this->featured_image ? asset('storage/' . $this->featured_image) : null,
            'images' => $this->images ? array_map(function ($image) {
                return asset('storage/' . $image);
            }, $this->images) : [],
            'extra_details' => self::cleanUtf8($this->extra_details ?? []),
            'is_featured' => $this->is_featured,
            'published_at' => $this->published_at?->toIso8601String(),

            // Relationships
            'city' => $this->whenLoaded('city', function () {
                return new CityResource($this->city);
            }),
            'district' => $this->whenLoaded('district', function () {
                return new DistrictResource($this->district);
            }),
            'subdistrict' => $this->whenLoaded('subdistrict', function () {
                return new SubdistrictResource($this->subdistrict);
            }),
            'agent' => $this->whenLoaded('agent', function () {
                return new AgentResource($this->agent);
            }),

            // SEO
            'seo' => [
                'title' => self::cleanUtf8($this->meta_title ?? $this->auto_meta_title),
                'description' => self::cleanUtf8($this->meta_description ?? $this->auto_meta_description),
            ],

            // Timestamps
            'created_at' => $this->created_at->toIso8601String(),
            'updated_at' => $this->updated_at->toIso8601String(),
        ];
    }

    /**
     * Recursively repair malformed/mis-encoded UTF-8 in free-text fields so a single
     * bad byte sequence (e.g. text pasted/imported as Windows-1253/ISO-8859-7,
     * a common source of mojibake for Greek content) can't break json_encode()
     * for the entire paginated response.
     *
     * @param mixed $value
     * @return mixed
     */
    private static function cleanUtf8(mixed $value): mixed
    {
        if (is_array($value)) {
            return array_map(fn($v) => self::cleanUtf8($v), $value);
        }

        if (!is_string($value) || $value === '' || mb_check_encoding($value, 'UTF-8')) {
            return $value;
        }

        // Most likely source encodings for mis-saved Greek content, tried via iconv
        // (mbstring's own encoding list doesn't include Windows-1253).
        foreach (['Windows-1253', 'ISO-8859-7', 'ISO-8859-1'] as $encoding) {
            $converted = @iconv($encoding, 'UTF-8', $value);
            if ($converted !== false && mb_check_encoding($converted, 'UTF-8')) {
                return $converted;
            }
        }

        // Fall back to stripping the invalid byte sequences outright.
        return @iconv('UTF-8', 'UTF-8//IGNORE', $value) ?: '';
    }
}
