<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\PageResource;
use App\Models\Page;
use Illuminate\Http\Request;

class PageController extends Controller
{
    public function index(Request $request)
    {
        $query = Page::where('status', 'published');

        if ($request->get('menu_only', false)) {
            $query->where('show_in_menu', true);
        }

        $pages = $query->orderBy('sort_order')->get();

        return PageResource::collection($pages);
    }

    public function show($slug)
    {
        $page = Page::where('slug', $slug)
            ->where('status', 'published')
            ->firstOrFail();

        return new PageResource($page);
    }
}
