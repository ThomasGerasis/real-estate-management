<?php

namespace App\Observers;

use App\Models\Agent;
use App\Services\CacheService;

class AgentObserver
{
    public function saved(Agent $agent): void
    {
        CacheService::forget("agents:show:{$agent->id}");
        CacheService::bumpVersion('agents');
        // Properties eager-load agent data
        CacheService::bumpVersion('properties');
    }

    public function deleted(Agent $agent): void
    {
        CacheService::forget("agents:show:{$agent->id}");
        CacheService::bumpVersion('agents');
        CacheService::bumpVersion('properties');
    }
}
