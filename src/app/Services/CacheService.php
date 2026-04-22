<?php

namespace App\Services;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class CacheService
{
    const TTL = 3600; // 1 hour

    /**
     * Cache a fixed-key value (single items, parameter-free endpoints).
     */
    public static function remember(string $key, callable $callback): mixed
    {
        return Cache::remember($key, self::TTL, $callback);
    }

    /**
     * Cache a value under a versioned key. Bumping the entity version
     * orphans all old keys (they expire after TTL) without needing tag support.
     */
    public static function rememberVersioned(string $entity, string $suffix, callable $callback): mixed
    {
        $version = (int) Cache::get("v:{$entity}", 1);
        $key = "{$entity}:v{$version}:{$suffix}";
        return Cache::remember($key, self::TTL, $callback);
    }

    /**
     * Increment the version for an entity, effectively invalidating all
     * versioned cache keys for that entity on the next request.
     */
    public static function bumpVersion(string $entity): void
    {
        $version = (int) Cache::get("v:{$entity}", 1);
        Cache::put("v:{$entity}", $version + 1, now()->addYear());
    }

    public static function forget(string ...$keys): void
    {
        foreach ($keys as $key) {
            Cache::forget($key);
        }
    }

    /**
     * Build a normalized cache key suffix from request query params.
     * Sorted to ensure identical param sets always produce the same key.
     */
    public static function requestKey(Request $request): string
    {
        $params = collect($request->query())->sortKeys()->all();
        return md5(serialize($params));
    }
}
