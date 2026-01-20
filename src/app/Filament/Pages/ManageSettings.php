<?php

namespace App\Filament\Pages;

use App\Models\Setting;
use Filament\Actions;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Pages\Page;
use Filament\Notifications\Notification;

class ManageSettings extends Page implements Forms\Contracts\HasForms
{
    use Forms\Concerns\InteractsWithForms;

    protected static ?string $navigationIcon = 'heroicon-o-cog-6-tooth';

    protected static ?string $navigationGroup = 'Settings';

    protected static ?int $navigationSort = 2;

    protected static string $view = 'filament.pages.manage-settings';

    protected static ?string $title = 'Site Settings';

    public ?array $data = [];

    public function mount(): void
    {
        $this->form->fill($this->getSettingsArray());
    }

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Tabs::make('Settings')
                    ->tabs([
                        Forms\Components\Tabs\Tab::make('General')
                            ->icon('heroicon-o-information-circle')
                            ->schema([
                                Forms\Components\TextInput::make('site_name')
                                    ->label('Site Name')
                                    ->maxLength(255)
                                    ->default(''),
                                Forms\Components\Textarea::make('site_description')
                                    ->label('Site Description')
                                    ->rows(3)
                                    ->maxLength(500)
                                    ->default(''),
                                Forms\Components\FileUpload::make('site_logo')
                                    ->label('Site Logo')
                                    ->image()
                                    ->directory('settings')
                                    ->imageEditor()
                                    ->nullable(),
                                Forms\Components\FileUpload::make('site_favicon')
                                    ->label('Favicon')
                                    ->image()
                                    ->directory('settings')
                                    ->acceptedFileTypes(['image/x-icon', 'image/png'])
                                    ->nullable(),
                            ]),
                        
                        Forms\Components\Tabs\Tab::make('Contact')
                            ->icon('heroicon-o-phone')
                            ->schema([
                                Forms\Components\TextInput::make('contact_email')
                                    ->label('Email')
                                    ->email()
                                    ->default(''),
                                Forms\Components\TextInput::make('contact_phone')
                                    ->label('Phone')
                                    ->tel()
                                    ->default(''),
                                Forms\Components\Textarea::make('contact_address')
                                    ->label('Address')
                                    ->rows(3)
                                    ->default(''),
                                Forms\Components\TextInput::make('contact_working_hours')
                                    ->label('Working Hours')
                                    ->placeholder('Mon-Fri: 9:00 AM - 6:00 PM')
                                    ->default(''),
                            ]),
                        
                        Forms\Components\Tabs\Tab::make('Social Media')
                            ->icon('heroicon-o-share')
                            ->schema([
                                Forms\Components\TextInput::make('social_facebook')
                                    ->label('Facebook URL')
                                    ->url()
                                    ->prefix('https://'),
                                Forms\Components\TextInput::make('social_twitter')
                                    ->label('Twitter/X URL')
                                    ->url()
                                    ->prefix('https://'),
                                Forms\Components\TextInput::make('social_instagram')
                                    ->label('Instagram URL')
                                    ->url()
                                    ->prefix('https://'),
                                Forms\Components\TextInput::make('social_linkedin')
                                    ->label('LinkedIn URL')
                                    ->url()
                                    ->prefix('https://'),
                                Forms\Components\TextInput::make('social_youtube')
                                    ->label('YouTube URL')
                                    ->url()
                                    ->prefix('https://'),
                            ]),
                        
                        Forms\Components\Tabs\Tab::make('SEO')
                            ->icon('heroicon-o-magnifying-glass')
                            ->schema([
                                Forms\Components\TextInput::make('seo_meta_title')
                                    ->label('Default Meta Title')
                                    ->maxLength(60)
                                    ->helperText('Used when page has no custom title'),
                                Forms\Components\Textarea::make('seo_meta_description')
                                    ->label('Default Meta Description')
                                    ->rows(3)
                                    ->maxLength(160)
                                    ->helperText('Used when page has no custom description'),
                                Forms\Components\Textarea::make('seo_meta_keywords')
                                    ->label('Meta Keywords')
                                    ->rows(2)
                                    ->helperText('Comma-separated keywords'),
                                Forms\Components\TextInput::make('seo_google_analytics')
                                    ->label('Google Analytics ID')
                                    ->placeholder('G-XXXXXXXXXX'),
                                Forms\Components\TextInput::make('seo_google_tag_manager')
                                    ->label('Google Tag Manager ID')
                                    ->placeholder('GTM-XXXXXXX'),
                            ]),
                        
                        Forms\Components\Tabs\Tab::make('Footer')
                            ->icon('heroicon-o-document-text')
                            ->schema([
                                Forms\Components\Textarea::make('footer_text')
                                    ->label('Footer Copyright Text')
                                    ->rows(2)
                                    ->placeholder('© 2025 Your Company. All rights reserved.'),
                                Forms\Components\RichEditor::make('footer_about')
                                    ->label('Footer About Text')
                                    ->columnSpanFull(),
                            ]),
                    ])
                    ->columnSpanFull(),
            ])
            ->statePath('data');
    }

    protected function getSettingsArray(): array
    {
        $settings = Setting::getAllSettings();
        
        if (empty($settings)) {
            return [];
        }
        
        $data = [];
        
        foreach ($settings as $key => $value) {
            // Skip empty values
            if ($value === null || $value === '') {
                continue;
            }
            
            // Try to decode JSON values (for file uploads)
            $decoded = json_decode($value, true);
            $data[$key] = $decoded ?? $value;
        }
        
        return $data;
    }

    public function save(): void
    {
        $data = $this->form->getState();
        
        foreach ($data as $key => $value) {
            // Handle array values (like file uploads)
            if (is_array($value)) {
                $value = json_encode($value);
            }
            
            Setting::set($key, $value ?? '', 'text', $this->getGroupForKey($key));
        }
        
        Notification::make()
            ->title('Settings saved successfully')
            ->success()
            ->send();
    }

    protected function getGroupForKey(string $key): string
    {
        if (str_starts_with($key, 'site_')) {
            return 'general';
        } elseif (str_starts_with($key, 'contact_')) {
            return 'contact';
        } elseif (str_starts_with($key, 'social_')) {
            return 'social';
        } elseif (str_starts_with($key, 'seo_')) {
            return 'seo';
        } elseif (str_starts_with($key, 'footer_')) {
            return 'footer';
        }
        
        return 'general';
    }

    protected function getFormActions(): array
    {
        return [
            Actions\Action::make('save')
                ->label('Save Settings')
                ->icon('heroicon-o-check')
                ->submit('save')
                ->color('primary'),
        ];
    }
}
