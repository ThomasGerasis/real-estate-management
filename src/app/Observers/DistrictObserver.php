<?php

namespace App\Observers;

use App\Models\District;
use App\Services\CacheService;

class DistrictObserver
{
    public function saved(District $district): void
    {
        $newCityId = $district->city_id;
        $oldCityId = $district->getOriginal('city_id');

        CacheService::forget(
            'cities:index',
            "cities:show:{$newCityId}",
            "cities:{$newCityId}:districts"
        );

        // If city_id changed, also invalidate the old city's caches
        if ($oldCityId && $oldCityId !== $newCityId) {
            CacheService::forget(
                "cities:show:{$oldCityId}",
                "cities:{$oldCityId}:districts"
            );
        }

        CacheService::bumpVersion('properties');
    }

    public function deleted(District $district): void
    {
        $cityId = $district->city_id;

        CacheService::forget(
            'cities:index',
            "cities:show:{$cityId}",
            "cities:{$cityId}:districts"
        );
        CacheService::bumpVersion('properties');
    }
}
