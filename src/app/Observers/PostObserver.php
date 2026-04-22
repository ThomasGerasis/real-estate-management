<?php

namespace App\Observers;

use App\Models\Post;
use App\Services\CacheService;

class PostObserver
{
    public function saved(Post $post): void
    {
        $oldSlug = $post->getOriginal('slug');

        CacheService::forget("posts:show:{$post->slug}");

        if ($oldSlug && $oldSlug !== $post->slug) {
            CacheService::forget("posts:show:{$oldSlug}");
        }

        CacheService::bumpVersion('posts');
    }

    public function deleted(Post $post): void
    {
        CacheService::forget("posts:show:{$post->slug}");
        CacheService::bumpVersion('posts');
    }
}
