<?php

namespace App\Providers;

use App\Models\Agent;
use App\Models\City;
use App\Models\District;
use App\Models\Menu;
use App\Models\Page;
use App\Models\Post;
use App\Models\Property;
use App\Observers\AgentObserver;
use App\Observers\CityObserver;
use App\Observers\DistrictObserver;
use App\Observers\MenuObserver;
use App\Observers\PageObserver;
use App\Observers\PostObserver;
use App\Observers\PropertyObserver;
use App\Models\Subdistrict;
use App\Observers\SubdistrictObserver;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        //
    }

    public function boot(): void
    {
        Menu::observe(MenuObserver::class);
        City::observe(CityObserver::class);
        District::observe(DistrictObserver::class);
        Subdistrict::observe(SubdistrictObserver::class);
        Page::observe(PageObserver::class);
        Agent::observe(AgentObserver::class);
        Post::observe(PostObserver::class);
        Property::observe(PropertyObserver::class);
    }
}
