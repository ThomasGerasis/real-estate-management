<?php

namespace App\Filament\Pages;

use Filament\Pages\Page;

class SetLocale extends Page
{
    protected static ?string $navigationIcon = 'heroicon-o-language';
    
    protected static string $view = 'filament.pages.set-locale';
    
    protected static bool $shouldRegisterNavigation = false;
    
    public function setLocale(string $locale): void
    {
        session(['locale' => $locale]);
        app()->setLocale($locale);
        
        $this->redirect(request()->header('Referer'));
    }
}
