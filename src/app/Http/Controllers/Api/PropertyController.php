<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\PropertyResource;
use App\Models\Property;
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
            new OA\Parameter(name: 'status', in: 'query', description: 'Filter by status (default: available)', schema: new OA\Schema(type: 'string', enum: ['available', 'sold', 'rented', 'reserved'])),
            new OA\Parameter(name: 'city_id', in: 'query', schema: new OA\Schema(type: 'integer')),
            new OA\Parameter(name: 'district_id', in: 'query', schema: new OA\Schema(type: 'integer')),
            new OA\Parameter(name: 'min_price', in: 'query', schema: new OA\Schema(type: 'number')),
            new OA\Parameter(name: 'max_price', in: 'query', schema: new OA\Schema(type: 'number')),
            new OA\Parameter(name: 'min_area', in: 'query', description: 'Minimum square meters', schema: new OA\Schema(type: 'number')),
            new OA\Parameter(name: 'max_area', in: 'query', description: 'Maximum square meters', schema: new OA\Schema(type: 'number')),
            new OA\Parameter(name: 'bedrooms', in: 'query', description: 'Minimum number of bedrooms', schema: new OA\Schema(type: 'integer')),
            new OA\Parameter(name: 'bathrooms', in: 'query', description: 'Minimum number of bathrooms', schema: new OA\Schema(type: 'integer')),
            new OA\Parameter(name: 'energy_class', in: 'query', schema: new OA\Schema(type: 'string', example: 'A')),
            new OA\Parameter(name: 'search', in: 'query', description: 'Search in title, description, address', schema: new OA\Schema(type: 'string')),
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
        $query = Property::with(['city', 'district', 'agent']);

        // Filter by listing type (sale/rent)
        if ($request->has('listing_type')) {
            $query->where('listing_type', $request->listing_type);
        }

        // Filter by type (house/apartment/commercial/land)
        if ($request->has('type')) {
            $query->where('type', $request->type);
        }

        // Filter by status
        if ($request->has('status')) {
            $query->where('status', $request->status);
        } else {
            // Default: only show available properties
            $query->where('status', 'available');
        }

        // Filter by city
        if ($request->has('city_id')) {
            $query->where('city_id', $request->city_id);
        }

        // Filter by district
        if ($request->has('district_id')) {
            $query->where('district_id', $request->district_id);
        }

        // Filter by price range
        if ($request->has('min_price')) {
            $query->where('price', '>=', $request->min_price);
        }
        if ($request->has('max_price')) {
            $query->where('price', '<=', $request->max_price);
        }

        // Filter by area (square meters)
        if ($request->has('min_area')) {
            $query->where('square_meters', '>=', $request->min_area);
        }
        if ($request->has('max_area')) {
            $query->where('square_meters', '<=', $request->max_area);
        }

        // Filter by bedrooms
        if ($request->has('bedrooms')) {
            $query->where('bedrooms', '>=', $request->bedrooms);
        }

        // Filter by bathrooms
        if ($request->has('bathrooms')) {
            $query->where('bathrooms', '>=', $request->bathrooms);
        }

        // Filter by energy class
        if ($request->has('energy_class')) {
            $query->where('energy_class', $request->energy_class);
        }

        // Search by title or description
        if ($request->has('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                  ->orWhere('description', 'like', "%{$search}%")
                  ->orWhere('address', 'like', "%{$search}%");
            });
        }

        // Sort
        $sortBy = $request->get('sort_by', 'created_at');
        $sortOrder = $request->get('sort_order', 'desc');
        $query->orderBy($sortBy, $sortOrder);

        // Paginate
        $perPage = $request->get('per_page', 12);
        $properties = $query->paginate($perPage);

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
        $property = Property::with(['city', 'district', 'agent'])
            ->findOrFail($id);

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
        
        $properties = Property::with(['city', 'district', 'agent'])
            ->where('is_featured', true)
            ->where('status', 'available')
            ->latest()
            ->limit($limit)
            ->get();

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
            new OA\Parameter(name: 'city_id', in: 'query', schema: new OA\Schema(type: 'integer')),
            new OA\Parameter(name: 'district_id', in: 'query', schema: new OA\Schema(type: 'integer')),
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
        $property = Property::findOrFail($id);
        $limit = $request->get('limit', 4);

        $similar = Property::with(['city', 'district', 'agent'])
            ->where('id', '!=', $id)
            ->where('type', $property->type)
            ->where('listing_type', $property->listing_type)
            ->where('status', 'available')
            ->where(function($query) use ($property) {
                $query->where('city_id', $property->city_id)
                      ->orWhereBetween('price', [
                          $property->price * 0.7,
                          $property->price * 1.3
                      ]);
            })
            ->limit($limit)
            ->get();

        return PropertyResource::collection($similar);
    }
}
