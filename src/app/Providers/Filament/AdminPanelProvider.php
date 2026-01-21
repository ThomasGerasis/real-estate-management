<?php

namespace App\Providers\Filament;

use Filament\Http\Middleware\Authenticate;
use Filament\Http\Middleware\AuthenticateSession;
use Filament\Http\Middleware\DisableBladeIconComponents;
use Filament\Http\Middleware\DispatchServingFilamentEvent;
use Filament\Navigation\MenuItem;
use Filament\Pages;
use Filament\Panel;
use Filament\PanelProvider;
use Filament\Support\Colors\Color;
use Filament\Widgets;
use Illuminate\Cookie\Middleware\AddQueuedCookiesToResponse;
use Illuminate\Cookie\Middleware\EncryptCookies;
use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken;
use Illuminate\Routing\Middleware\SubstituteBindings;
use Illuminate\Session\Middleware\StartSession;
use Illuminate\View\Middleware\ShareErrorsFromSession;
use Filament\SpatieLaravelTranslatablePlugin;

class AdminPanelProvider extends PanelProvider
{
    public function panel(Panel $panel): Panel
    {
        return $panel
            ->default()
            ->id('admin')
            ->path('admin')
            ->login()
            ->brandName('Real Estate Admin')
            ->favicon(asset('favicon.ico'))
            ->colors([
                'primary' => Color::Blue,
                'success' => Color::Green,
                'warning' => Color::Amber,
                'danger' => Color::Red,
            ])
            ->discoverResources(in: app_path('Filament/Resources'), for: 'App\\Filament\\Resources')
            ->discoverPages(in: app_path('Filament/Pages'), for: 'App\\Filament\\Pages')
            ->pages([
                \App\Filament\Pages\Dashboard::class,
            ])
            ->discoverWidgets(in: app_path('Filament/Widgets'), for: 'App\\Filament\\Widgets')
            ->widgets([
                \App\Filament\Widgets\PropertiesStatsOverview::class,
                \App\Filament\Widgets\PropertiesByTypeChart::class,
                \App\Filament\Widgets\LatestProperties::class,
            ])
            ->navigationGroups([
                __('lang.navigation_groups.properties'),
                __('lang.navigation_groups.content'),
                __('lang.navigation_groups.users'),
                __('lang.navigation_groups.settings'),
            ])
            ->sidebarCollapsibleOnDesktop()
            ->plugin(
                SpatieLaravelTranslatablePlugin::make()
                    ->defaultLocales(['el', 'en'])
            )
            ->userMenuItems([
                'locale_el' => MenuItem::make()
                    ->label('Ελληνικά')
                    ->icon('heroicon-o-language')
                    ->url(fn () => route('filament.admin.switch-locale', ['locale' => 'el']))
                    ->visible(fn () => app()->getLocale() !== 'el'),
                'locale_en' => MenuItem::make()
                    ->label('English')
                    ->icon('heroicon-o-language')
                    ->url(fn () => route('filament.admin.switch-locale', ['locale' => 'en']))
                    ->visible(fn () => app()->getLocale() !== 'en'),
            ])
            ->middleware([
                EncryptCookies::class,
                AddQueuedCookiesToResponse::class,
                StartSession::class,
                ShareErrorsFromSession::class,
                \App\Http\Middleware\SetLocale::class,
                AuthenticateSession::class,
                VerifyCsrfToken::class,
                SubstituteBindings::class,
                DisableBladeIconComponents::class,
                DispatchServingFilamentEvent::class,
            ])
            ->authMiddleware([
                Authenticate::class,
            ]);
    }
}
