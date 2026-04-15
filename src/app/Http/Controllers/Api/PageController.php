<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\PageResource;
use App\Models\Page;
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
        $query = Page::where('status', 'published');

        if ($request->get('menu_only', false)) {
            $query->where('show_in_menu', true);
        }

        $pages = $query->orderBy('sort_order')->get();

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
        $page = Page::where('slug', $slug)
            ->where('status', 'published')
            ->firstOrFail();

        return new PageResource($page);
    }
}
