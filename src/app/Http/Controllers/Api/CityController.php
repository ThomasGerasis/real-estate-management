<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\CityResource;
use App\Http\Resources\DistrictResource;
use App\Models\City;
use App\Models\District;
use App\Services\CacheService;
use Illuminate\Http\Request;
use OpenApi\Attributes as OA;

class CityController extends Controller
{
    #[OA\Get(
        path: '/cities',
        summary: 'List active cities',
        tags: ['Cities'],
        responses: [
            new OA\Response(response: 200, description: 'City list', content: new OA\JsonContent(properties: [new OA\Property(property: 'data', type: 'array', items: new OA\Items(ref: '#/components/schemas/City'))])),
        ]
    )]
    public function index()
    {
        $cities = CacheService::remember('cities:index', fn() => City::where('is_active', true)
            ->withCount('properties')
            ->orderBy('name')
            ->get());

        return CityResource::collection($cities);
    }

    #[OA\Get(
        path: '/cities/{id}',
        summary: 'Get a city with its districts',
        tags: ['Cities'],
        parameters: [
            new OA\Parameter(name: 'id', in: 'path', required: true, schema: new OA\Schema(type: 'integer')),
        ],
        responses: [
            new OA\Response(response: 200, description: 'City detail', content: new OA\JsonContent(properties: [new OA\Property(property: 'data', ref: '#/components/schemas/City')])),
            new OA\Response(response: 404, description: 'Not found'),
        ]
    )]
    public function show($id)
    {
        $city = CacheService::remember("cities:show:{$id}", fn() => City::with('districts')
            ->withCount('properties')
            ->findOrFail($id));

        return new CityResource($city);
    }

    #[OA\Get(
        path: '/cities/{id}/districts',
        summary: 'Get districts for a city',
        tags: ['Cities'],
        parameters: [
            new OA\Parameter(name: 'id', in: 'path', required: true, schema: new OA\Schema(type: 'integer')),
        ],
        responses: [
            new OA\Response(response: 200, description: 'District list', content: new OA\JsonContent(properties: [new OA\Property(property: 'data', type: 'array', items: new OA\Items(ref: '#/components/schemas/District'))])),
        ]
    )]
    public function districts($id)
    {
        $districts = CacheService::remember("cities:{$id}:districts", fn() => District::where('city_id', $id)
            ->where('is_active', true)
            ->withCount('properties')
            ->orderBy('name')
            ->get());

        return DistrictResource::collection($districts);
    }
}
