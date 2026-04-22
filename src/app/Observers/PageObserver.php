<?php

namespace App\Observers;

use App\Models\Page;
use App\Services\CacheService;

class PageObserver
{
    public function saved(Page $page): void
    {
        $oldSlug = $page->getOriginal('slug');

        CacheService::forget('pages:index', 'pages:index:menu_only', "pages:show:{$page->slug}");

        if ($oldSlug && $oldSlug !== $page->slug) {
            CacheService::forget("pages:show:{$oldSlug}");
        }
    }

    public function deleted(Page $page): void
    {
        CacheService::forget('pages:index', 'pages:index:menu_only', "pages:show:{$page->slug}");
    }
}
