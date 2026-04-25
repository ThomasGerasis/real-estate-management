<?php

namespace App\Observers;

use App\Models\Subdistrict;
use App\Services\CacheService;

class SubdistrictObserver
{
    public function saved(Subdistrict $subdistrict): void
    {
        $districtId = $subdistrict->district_id;
        $oldDistrictId = $subdistrict->getOriginal('district_id');

        CacheService::forget(
            "districts:{$districtId}:subdistricts"
        );

        if ($oldDistrictId && $oldDistrictId !== $districtId) {
            CacheService::forget("districts:{$oldDistrictId}:subdistricts");
        }

        CacheService::bumpVersion('properties');
    }

    public function deleted(Subdistrict $subdistrict): void
    {
        CacheService::forget("districts:{$subdistrict->district_id}:subdistricts");
        CacheService::bumpVersion('properties');
    }
}
