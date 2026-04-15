<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use OpenApi\Attributes as OA;

#[OA\Schema(
    schema: 'Page',
    properties: [
        new OA\Property(property: 'id', type: 'integer', example: 1),
        new OA\Property(property: 'title', type: 'string'),
        new OA\Property(property: 'slug', type: 'string'),
        new OA\Property(property: 'template', type: 'string', example: 'default'),
        new OA\Property(property: 'content', type: 'string', nullable: true),
        new OA\Property(property: 'excerpt', type: 'string', nullable: true),
        new OA\Property(property: 'featured_image', type: 'string', format: 'uri', nullable: true),
        new OA\Property(property: 'status', type: 'string', enum: ['published', 'draft']),
        new OA\Property(property: 'sort_order', type: 'integer'),
        new OA\Property(property: 'show_in_menu', type: 'boolean'),
        new OA\Property(property: 'published_at', type: 'string', format: 'date-time', nullable: true),
        new OA\Property(property: 'seo', ref: '#/components/schemas/Seo'),
        new OA\Property(property: 'created_at', type: 'string', format: 'date-time'),
        new OA\Property(property: 'updated_at', type: 'string', format: 'date-time'),
    ],
    type: 'object'
)]
class PageResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'title' => $this->title,
            'slug' => $this->slug,
            'template' => $this->template ?? 'default',
            'content' => $this->content,
            'excerpt' => $this->excerpt,
            'featured_image' => $this->featured_image ? asset('storage/' . $this->featured_image) : null,
            'status' => $this->status,
            'sort_order' => $this->sort_order,
            'show_in_menu' => $this->show_in_menu,
            'published_at' => $this->published_at?->toIso8601String(),
            'seo' => [
                'title' => $this->meta_title ?? $this->title,
                'description' => $this->meta_description ?? $this->excerpt,
            ],
            'created_at' => $this->created_at->toIso8601String(),
            'updated_at' => $this->updated_at->toIso8601String(),
        ];
    }
}
