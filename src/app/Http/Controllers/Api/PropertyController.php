<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\PropertyResource;
use App\Models\Property;
use App\Services\CacheService;
use Illuminate\Http\Request;
use OpenApi\Attributes as OA;

class PropertyController extends Controller
{
    #[OA\Get(
        path: '/properties',
        summary: 'List properties',
        description: 'Returns a paginated list of properties with optional filters.',
        tags: ['Properties'],
        parameters: [
            new OA\Parameter(name: 'listing_type', in: 'query', description: 'Filter by listing type', schema: new OA\Schema(type: 'string', enum: ['sale', 'rent'])),
            new OA\Parameter(name: 'type', in: 'query', description: 'Filter by property type', schema: new OA\Schema(type: 'string', enum: ['house', 'apartment', 'commercial', 'land'])),
            new OA\Parameter(name: 'property_type', in: 'query', description: 'Filter by property type (alias for type)', schema: new OA\Schema(type: 'string', enum: ['house', 'apartment', 'commercial', 'land'])),
            new OA\Parameter(name: 'status', in: 'query', description: 'Filter by status (default: available)', schema: new OA\Schema(type: 'string', enum: ['available', 'sold', 'rented', 'reserved'])),
            new OA\Parameter(name: 'city_id', in: 'query', schema: new OA\Schema(type: 'integer')),
            new OA\Parameter(name: 'district_id', in: 'query', schema: new OA\Schema(type: 'integer')),
            new OA\Parameter(name: 'subdistrict_id', in: 'query', schema: new OA\Schema(type: 'integer')),
            new OA\Parameter(name: 'min_price', in: 'query', schema: new OA\Schema(type: 'number')),
            new OA\Parameter(name: 'max_price', in: 'query', schema: new OA\Schema(type: 'number')),
            new OA\Parameter(name: 'min_area', in: 'query', description: 'Minimum square meters', schema: new OA\Schema(type: 'number')),
            new OA\Parameter(name: 'max_area', in: 'query', description: 'Maximum square meters', schema: new OA\Schema(type: 'number')),
            new OA\Parameter(name: 'bedrooms', in: 'query', description: 'Minimum number of bedrooms', schema: new OA\Schema(type: 'integer')),
            new OA\Parameter(name: 'bathrooms', in: 'query', description: 'Minimum number of bathrooms', schema: new OA\Schema(type: 'integer')),
            new OA\Parameter(name: 'energy_class', in: 'query', schema: new OA\Schema(type: 'string', example: 'A')),
            new OA\Parameter(name: 'search', in: 'query', description: 'Search in title, description', schema: new OA\Schema(type: 'string')),
            new OA\Parameter(name: 'sort_by', in: 'query', schema: new OA\Schema(type: 'string', default: 'created_at')),
            new OA\Parameter(name: 'sort_order', in: 'query', schema: new OA\Schema(type: 'string', enum: ['asc', 'desc'], default: 'desc')),
            new OA\Parameter(name: 'per_page', in: 'query', schema: new OA\Schema(type: 'integer', default: 12)),
        ],
        responses: [
            new OA\Response(
                response: 200,
                description: 'Paginated property list',
                content: new OA\JsonContent(properties: [
                    new OA\Property(property: 'data', type: 'array', items: new OA\Items(ref: '#/components/schemas/Property')),
                    new OA\Property(property: 'links', ref: '#/components/schemas/PaginationLinks'),
                    new OA\Property(property: 'meta', ref: '#/components/schemas/PaginationMeta'),
                ])
            ),
        ]
    )]
    public function index(Request $request)
    {
        $key = CacheService::requestKey($request);
        $properties = CacheService::rememberVersioned('properties', $key, function () use ($request) {
            $query = Property::with(['city', 'district', 'subdistrict', 'agent'])
                ->where('publish_status', 'published');

            if ($request->has('listing_type')) {
                $query->where('listing_type', $request->listing_type);
            }

            $typeFilter = $request->input('property_type', $request->input('type'));
            if ($typeFilter) {
                $query->where('type', $typeFilter);
            }

            if ($request->has('status')) {
                $query->where('status', $request->status);
            } else {
                $query->where('status', 'available');
            }

            if ($request->has('city_id')) {
                $query->where('city_id', $request->city_id);
            }

            if ($request->has('district_id')) {
                $query->where('district_id', $request->district_id);
            }

            if ($request->has('subdistrict_id')) {
                $query->where('subdistrict_id', $request->subdistrict_id);
            }

            if ($request->has('min_price')) {
                $query->where('price', '>=', $request->min_price);
            }
            if ($request->has('max_price')) {
                $query->where('price', '<=', $request->max_price);
            }

            if ($request->has('min_area')) {
                $query->where('square_meters', '>=', $request->min_area);
            }
            if ($request->has('max_area')) {
                $query->where('square_meters', '<=', $request->max_area);
            }

            if ($request->has('bedrooms')) {
                $query->where('bedrooms', '>=', $request->bedrooms);
            }

            if ($request->has('bathrooms')) {
                $query->where('bathrooms', '>=', $request->bathrooms);
            }

            if ($request->has('energy_class')) {
                $query->where('energy_class', $request->energy_class);
            }

            if ($request->has('search')) {
                $search = $request->search;
                $query->where(function ($q) use ($search) {
                    $q->where('title', 'like', "%{$search}%")
                      ->orWhere('description', 'like', "%{$search}%");
                });
            }

            $sortBy = $request->get('sort_by', 'created_at');
            $sortOrder = $request->get('sort_order', 'desc');
            $query->orderBy($sortBy, $sortOrder);

            return $query->paginate($request->get('per_page', 12));
        });

        return PropertyResource::collection($properties);
    }

    #[OA\Get(
        path: '/properties/{id}',
        summary: 'Get a property',
        tags: ['Properties'],
        parameters: [
            new OA\Parameter(name: 'id', in: 'path', required: true, schema: new OA\Schema(type: 'integer')),
        ],
        responses: [
            new OA\Response(response: 200, description: 'Property detail', content: new OA\JsonContent(properties: [new OA\Property(property: 'data', ref: '#/components/schemas/Property')])),
            new OA\Response(response: 404, description: 'Not found'),
        ]
    )]
    public function show($id)
    {
        $property = CacheService::remember("properties:show:{$id}", fn() => Property::with(['city', 'district', 'subdistrict', 'agent'])
            ->where('publish_status', 'published')
            ->findOrFail($id));

        return new PropertyResource($property);
    }

    #[OA\Get(
        path: '/properties/featured',
        summary: 'Get featured properties',
        tags: ['Properties'],
        parameters: [
            new OA\Parameter(name: 'limit', in: 'query', schema: new OA\Schema(type: 'integer', default: 6)),
        ],
        responses: [
            new OA\Response(response: 200, description: 'Featured properties', content: new OA\JsonContent(properties: [new OA\Property(property: 'data', type: 'array', items: new OA\Items(ref: '#/components/schemas/Property'))])),
        ]
    )]
    public function featured(Request $request)
    {
        $limit = $request->get('limit', 6);
        $properties = CacheService::rememberVersioned('properties', "featured:{$limit}", fn() => Property::with(['city', 'district', 'subdistrict', 'agent'])
            ->where('is_featured', true)
            ->where('status', 'available')
            ->where('publish_status', 'published')
            ->latest()
            ->limit($limit)
            ->get());

        return PropertyResource::collection($properties);
    }

    #[OA\Get(
        path: '/properties/search',
        summary: 'Advanced property search',
        description: 'Accepts the same filters as GET /properties.',
        tags: ['Properties'],
        parameters: [
            new OA\Parameter(name: 'listing_type', in: 'query', schema: new OA\Schema(type: 'string', enum: ['sale', 'rent'])),
            new OA\Parameter(name: 'type', in: 'query', schema: new OA\Schema(type: 'string', enum: ['house', 'apartment', 'commercial', 'land'])),
            new OA\Parameter(name: 'property_type', in: 'query', schema: new OA\Schema(type: 'string', enum: ['house', 'apartment', 'commercial', 'land'])),
            new OA\Parameter(name: 'city_id', in: 'query', schema: new OA\Schema(type: 'integer')),
            new OA\Parameter(name: 'district_id', in: 'query', schema: new OA\Schema(type: 'integer')),
            new OA\Parameter(name: 'subdistrict_id', in: 'query', schema: new OA\Schema(type: 'integer')),
            new OA\Parameter(name: 'min_price', in: 'query', schema: new OA\Schema(type: 'number')),
            new OA\Parameter(name: 'max_price', in: 'query', schema: new OA\Schema(type: 'number')),
            new OA\Parameter(name: 'min_area', in: 'query', schema: new OA\Schema(type: 'number')),
            new OA\Parameter(name: 'max_area', in: 'query', schema: new OA\Schema(type: 'number')),
            new OA\Parameter(name: 'bedrooms', in: 'query', schema: new OA\Schema(type: 'integer')),
            new OA\Parameter(name: 'bathrooms', in: 'query', schema: new OA\Schema(type: 'integer')),
            new OA\Parameter(name: 'energy_class', in: 'query', schema: new OA\Schema(type: 'string')),
            new OA\Parameter(name: 'search', in: 'query', schema: new OA\Schema(type: 'string')),
            new OA\Parameter(name: 'sort_by', in: 'query', schema: new OA\Schema(type: 'string', default: 'created_at')),
            new OA\Parameter(name: 'sort_order', in: 'query', schema: new OA\Schema(type: 'string', enum: ['asc', 'desc'], default: 'desc')),
            new OA\Parameter(name: 'per_page', in: 'query', schema: new OA\Schema(type: 'integer', default: 12)),
        ],
        responses: [
            new OA\Response(response: 200, description: 'Paginated results', content: new OA\JsonContent(properties: [
                new OA\Property(property: 'data', type: 'array', items: new OA\Items(ref: '#/components/schemas/Property')),
                new OA\Property(property: 'links', ref: '#/components/schemas/PaginationLinks'),
                new OA\Property(property: 'meta', ref: '#/components/schemas/PaginationMeta'),
            ])),
        ]
    )]
    public function search(Request $request)
    {
        return $this->index($request);
    }

    #[OA\Get(
        path: '/properties/type-counts',
        summary: 'Get property counts by type',
        description: 'Returns total count per property type across all available properties.',
        tags: ['Properties'],
        responses: [
            new OA\Response(
                response: 200,
                description: 'Property counts by type',
                content: new OA\JsonContent(
                    example: ['house' => 12, 'apartment' => 34, 'commercial' => 5, 'land' => 8]
                )
            ),
        ]
    )]
    public function typeCounts()
    {
        $counts = CacheService::rememberVersioned('properties', 'type_counts', fn() => Property::selectRaw('type, count(*) as total')
            ->where('publish_status', 'published')
            ->groupBy('type')
            ->pluck('total', 'type'));

        return response()->json($counts);
    }

    #[OA\Get(
        path: '/properties/{id}/similar',
        summary: 'Get similar properties',
        tags: ['Properties'],
        parameters: [
            new OA\Parameter(name: 'id', in: 'path', required: true, schema: new OA\Schema(type: 'integer')),
            new OA\Parameter(name: 'limit', in: 'query', schema: new OA\Schema(type: 'integer', default: 4)),
        ],
        responses: [
            new OA\Response(response: 200, description: 'Similar properties', content: new OA\JsonContent(properties: [new OA\Property(property: 'data', type: 'array', items: new OA\Items(ref: '#/components/schemas/Property'))])),
            new OA\Response(response: 404, description: 'Property not found'),
        ]
    )]
    public function similar($id, Request $request)
    {
        $limit = $request->get('limit', 4);
        $properties = CacheService::rememberVersioned('properties', "similar:{$id}:{$limit}", function () use ($id, $limit) {
            $property = Property::findOrFail($id);

            return Property::with(['city', 'district', 'subdistrict', 'agent'])
                ->where('id', '!=', $id)
                ->where('type', $property->type)
                ->where('listing_type', $property->listing_type)
                ->where('status', 'available')
                ->where('publish_status', 'published')
                ->where(function ($query) use ($property) {
                    $query->where('city_id', $property->city_id)
                          ->orWhereBetween('price', [
                              $property->price * 0.7,
                              $property->price * 1.3,
                          ]);
                })
                ->limit($limit)
                ->get();
        });

        return PropertyResource::collection($properties);
    }
}
