<?php

namespace App\Observers;

use App\Models\City;
use App\Services\CacheService;

class CityObserver
{
    public function saved(City $city): void
    {
        CacheService::forget(
            'cities:index',
            "cities:show:{$city->id}",
            "cities:{$city->id}:districts"
        );
        CacheService::bumpVersion('properties');
    }

    public function deleted(City $city): void
    {
        CacheService::forget(
            'cities:index',
            "cities:show:{$city->id}",
            "cities:{$city->id}:districts"
        );
        CacheService::bumpVersion('properties');
    }
}
