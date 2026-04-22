<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\PostResource;
use App\Models\Post;
use App\Services\CacheService;
use Illuminate\Http\Request;
use OpenApi\Attributes as OA;

class PostController extends Controller
{
    #[OA\Get(
        path: '/posts',
        summary: 'List blog posts',
        tags: ['Posts'],
        parameters: [
            new OA\Parameter(name: 'search', in: 'query', description: 'Search in title, excerpt, content', schema: new OA\Schema(type: 'string')),
            new OA\Parameter(name: 'per_page', in: 'query', schema: new OA\Schema(type: 'integer', default: 10)),
        ],
        responses: [
            new OA\Response(response: 200, description: 'Paginated post list', content: new OA\JsonContent(properties: [
                new OA\Property(property: 'data', type: 'array', items: new OA\Items(ref: '#/components/schemas/Post')),
                new OA\Property(property: 'links', ref: '#/components/schemas/PaginationLinks'),
                new OA\Property(property: 'meta', ref: '#/components/schemas/PaginationMeta'),
            ])),
        ]
    )]
    public function index(Request $request)
    {
        $key = CacheService::requestKey($request);
        $posts = CacheService::rememberVersioned('posts', $key, function () use ($request) {
            $query = Post::where('status', 'published');

            if ($request->has('search')) {
                $search = $request->search;
                $query->where(function ($q) use ($search) {
                    $q->where('title', 'like', "%{$search}%")
                      ->orWhere('excerpt', 'like', "%{$search}%")
                      ->orWhere('content', 'like', "%{$search}%");
                });
            }

            return $query->latest('published_at')->paginate($request->get('per_page', 10));
        });

        return PostResource::collection($posts);
    }

    #[OA\Get(
        path: '/posts/{slug}',
        summary: 'Get a post by slug',
        tags: ['Posts'],
        parameters: [
            new OA\Parameter(name: 'slug', in: 'path', required: true, schema: new OA\Schema(type: 'string')),
        ],
        responses: [
            new OA\Response(response: 200, description: 'Post detail', content: new OA\JsonContent(properties: [new OA\Property(property: 'data', ref: '#/components/schemas/Post')])),
            new OA\Response(response: 404, description: 'Not found'),
        ]
    )]
    public function show($slug)
    {
        $post = CacheService::remember("posts:show:{$slug}", fn() => Post::where('slug', $slug)
            ->where('status', 'published')
            ->firstOrFail());

        return new PostResource($post);
    }

    #[OA\Get(
        path: '/posts/latest',
        summary: 'Get latest posts',
        tags: ['Posts'],
        parameters: [
            new OA\Parameter(name: 'limit', in: 'query', schema: new OA\Schema(type: 'integer', default: 3)),
        ],
        responses: [
            new OA\Response(response: 200, description: 'Latest posts', content: new OA\JsonContent(properties: [new OA\Property(property: 'data', type: 'array', items: new OA\Items(ref: '#/components/schemas/Post'))])),
        ]
    )]
    public function latest(Request $request)
    {
        $limit = $request->get('limit', 3);
        $posts = CacheService::rememberVersioned('posts', "latest:{$limit}", fn() => Post::where('status', 'published')
            ->latest('published_at')
            ->limit($limit)
            ->get());

        return PostResource::collection($posts);
    }
}
