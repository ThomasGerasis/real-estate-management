<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\MenuResource;
use App\Models\Menu;
use App\Services\CacheService;
use Illuminate\Http\Request;
use OpenApi\Attributes as OA;

class MenuController extends Controller
{
    #[OA\Get(
        path: '/menu/header',
        summary: 'Get header menu',
        tags: ['Menu'],
        responses: [
            new OA\Response(response: 200, description: 'Header menu items', content: new OA\JsonContent(properties: [new OA\Property(property: 'data', type: 'array', items: new OA\Items(ref: '#/components/schemas/MenuItem'))])),
        ]
    )]
    public function header()
    {
        $menus = CacheService::remember('menu:header', fn() => Menu::header()->with('children')->get());
        return MenuResource::collection($menus);
    }

    #[OA\Get(
        path: '/menu/footer',
        summary: 'Get footer menu',
        tags: ['Menu'],
        responses: [
            new OA\Response(response: 200, description: 'Footer menu items', content: new OA\JsonContent(properties: [new OA\Property(property: 'data', type: 'array', items: new OA\Items(ref: '#/components/schemas/MenuItem'))])),
        ]
    )]
    public function footer()
    {
        $menus = CacheService::remember('menu:footer', fn() => Menu::footer()->with('children')->get());
        return MenuResource::collection($menus);
    }

    #[OA\Get(
        path: '/menu',
        summary: 'Get all menus (header + footer)',
        tags: ['Menu'],
        responses: [
            new OA\Response(
                response: 200,
                description: 'All menus',
                content: new OA\JsonContent(properties: [
                    new OA\Property(property: 'header', type: 'array', items: new OA\Items(ref: '#/components/schemas/MenuItem')),
                    new OA\Property(property: 'footer', type: 'array', items: new OA\Items(ref: '#/components/schemas/MenuItem')),
                ])
            ),
        ]
    )]
    public function all()
    {
        $data = CacheService::remember('menu:all', fn() => [
            'header' => Menu::header()->with('children')->get(),
            'footer' => Menu::footer()->with('children')->get(),
        ]);

        return [
            'header' => MenuResource::collection($data['header']),
            'footer' => MenuResource::collection($data['footer']),
        ];
    }
}
