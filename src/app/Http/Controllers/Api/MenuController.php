<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\MenuResource;
use App\Models\Menu;
use Illuminate\Http\Request;

class MenuController extends Controller
{
    public function header()
    {
        $menus = Menu::header()->with('children')->get();
        return MenuResource::collection($menus);
    }

    public function footer()
    {
        $menus = Menu::footer()->with('children')->get();
        return MenuResource::collection($menus);
    }

    public function all()
    {
        return [
            'header' => MenuResource::collection(Menu::header()->with('children')->get()),
            'footer' => MenuResource::collection(Menu::footer()->with('children')->get()),
        ];
    }
}
