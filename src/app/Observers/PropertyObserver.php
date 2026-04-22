<?php

namespace App\Observers;

use App\Models\Property;
use App\Services\CacheService;

class PropertyObserver
{
    public function saved(Property $property): void
    {
        CacheService::forget("properties:show:{$property->id}");
        CacheService::bumpVersion('properties');
    }

    public function deleted(Property $property): void
    {
        CacheService::forget("properties:show:{$property->id}");
        CacheService::bumpVersion('properties');
    }
}
