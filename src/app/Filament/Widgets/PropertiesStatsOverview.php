<?php

namespace App\Filament\Widgets;

use App\Models\Property;
use App\Models\Agent;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class PropertiesStatsOverview extends BaseWidget
{
    protected function getStats(): array
    {
        return [
            Stat::make('Total Properties', Property::count())
                ->description('All properties in database')
                ->descriptionIcon('heroicon-m-home')
                ->color('success'),
            
            Stat::make('Available Properties', Property::where('status', 'available')->count())
                ->description('Ready for sale/rent')
                ->descriptionIcon('heroicon-m-check-circle')
                ->color('info'),
            
            Stat::make('Sold Properties', Property::where('status', 'sold')->count())
                ->description('This month')
                ->descriptionIcon('heroicon-m-currency-euro')
                ->color('warning'),
            
            Stat::make('Active Agents', Agent::where('is_active', true)->count())
                ->description('Total active agents')
                ->descriptionIcon('heroicon-m-user-group')
                ->color('primary'),
        ];
    }
}
