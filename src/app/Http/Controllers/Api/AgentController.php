<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\AgentResource;
use App\Models\Agent;
use App\Services\CacheService;
use Illuminate\Http\Request;
use OpenApi\Attributes as OA;

class AgentController extends Controller
{
    #[OA\Get(
        path: '/agents',
        summary: 'List agents',
        tags: ['Agents'],
        parameters: [
            new OA\Parameter(name: 'search', in: 'query', description: 'Search by name or bio', schema: new OA\Schema(type: 'string')),
            new OA\Parameter(name: 'per_page', in: 'query', schema: new OA\Schema(type: 'integer', default: 12)),
        ],
        responses: [
            new OA\Response(response: 200, description: 'Paginated agent list', content: new OA\JsonContent(properties: [
                new OA\Property(property: 'data', type: 'array', items: new OA\Items(ref: '#/components/schemas/Agent')),
                new OA\Property(property: 'links', ref: '#/components/schemas/PaginationLinks'),
                new OA\Property(property: 'meta', ref: '#/components/schemas/PaginationMeta'),
            ])),
        ]
    )]
    public function index(Request $request)
    {
        $key = CacheService::requestKey($request);
        $agents = CacheService::rememberVersioned('agents', $key, function () use ($request) {
            $query = Agent::where('is_active', true)->withCount('properties');

            if ($request->has('search')) {
                $search = $request->search;
                $query->where(function ($q) use ($search) {
                    $q->where('name', 'like', "%{$search}%")
                      ->orWhere('bio', 'like', "%{$search}%");
                });
            }

            return $query->paginate($request->get('per_page', 12));
        });

        return AgentResource::collection($agents);
    }

    #[OA\Get(
        path: '/agents/{id}',
        summary: 'Get an agent',
        tags: ['Agents'],
        parameters: [
            new OA\Parameter(name: 'id', in: 'path', required: true, schema: new OA\Schema(type: 'integer')),
        ],
        responses: [
            new OA\Response(response: 200, description: 'Agent detail with properties', content: new OA\JsonContent(properties: [new OA\Property(property: 'data', ref: '#/components/schemas/Agent')])),
            new OA\Response(response: 404, description: 'Not found'),
        ]
    )]
    public function show($id)
    {
        $agent = CacheService::remember("agents:show:{$id}", fn() => Agent::with('properties')
            ->withCount('properties')
            ->findOrFail($id));

        return new AgentResource($agent);
    }
}
