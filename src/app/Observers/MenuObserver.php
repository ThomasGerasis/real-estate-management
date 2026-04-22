<?php

namespace App\Observers;

use App\Models\Menu;
use App\Services\CacheService;

class MenuObserver
{
    public function saved(Menu $menu): void
    {
        CacheService::forget('menu:header', 'menu:footer', 'menu:all');
    }

    public function deleted(Menu $menu): void
    {
        CacheService::forget('menu:header', 'menu:footer', 'menu:all');
    }
}
