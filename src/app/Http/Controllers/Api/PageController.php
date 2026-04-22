<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\PageResource;
use App\Models\Page;
use App\Services\CacheService;
use Illuminate\Http\Request;
use OpenApi\Attributes as OA;

class PageController extends Controller
{
    #[OA\Get(
        path: '/pages',
        summary: 'List published pages',
        tags: ['Pages'],
        parameters: [
            new OA\Parameter(name: 'menu_only', in: 'query', description: 'Return only pages shown in menu', schema: new OA\Schema(type: 'boolean', default: false)),
        ],
        responses: [
            new OA\Response(response: 200, description: 'Page list', content: new OA\JsonContent(properties: [new OA\Property(property: 'data', type: 'array', items: new OA\Items(ref: '#/components/schemas/Page'))])),
        ]
    )]
    public function index(Request $request)
    {
        $menuOnly = (bool) $request->get('menu_only', false);
        $cacheKey = $menuOnly ? 'pages:index:menu_only' : 'pages:index';

        $pages = CacheService::remember($cacheKey, function () use ($menuOnly) {
            $query = Page::where('status', 'published');
            if ($menuOnly) {
                $query->where('show_in_menu', true);
            }
            return $query->orderBy('sort_order')->get();
        });

        return PageResource::collection($pages);
    }

    #[OA\Get(
        path: '/pages/{slug}',
        summary: 'Get a page by slug',
        tags: ['Pages'],
        parameters: [
            new OA\Parameter(name: 'slug', in: 'path', required: true, schema: new OA\Schema(type: 'string')),
        ],
        responses: [
            new OA\Response(response: 200, description: 'Page detail', content: new OA\JsonContent(properties: [new OA\Property(property: 'data', ref: '#/components/schemas/Page')])),
            new OA\Response(response: 404, description: 'Not found'),
        ]
    )]
    public function show($slug)
    {
        $page = CacheService::remember("pages:show:{$slug}", fn() => Page::where('slug', $slug)
            ->where('status', 'published')
            ->firstOrFail());

        return new PageResource($page);
    }
}
