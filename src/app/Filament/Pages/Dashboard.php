<?php

namespace App\Filament\Pages;

use Filament\Pages\Dashboard as BaseDashboard;

class Dashboard extends BaseDashboard
{
    protected static ?string $navigationIcon = 'heroicon-o-home';

    protected static string $routePath = '/';

    protected static ?int $navigationSort = -2;

    public function getWidgets(): array
    {
        return [
            \App\Filament\Widgets\PropertiesStatsOverview::class,
            \App\Filament\Widgets\LatestProperties::class,
        ];
    }

    public function getColumns(): int | string | array
    {
        return 2;
    }
}
