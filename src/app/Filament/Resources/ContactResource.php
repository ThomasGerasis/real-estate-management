<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ContactResource\Pages;
use App\Filament\Resources\ContactResource\RelationManagers;
use App\Models\Contact;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class ContactResource extends Resource
{
    protected static ?string $model = Contact::class;

    protected static ?string $navigationIcon = 'heroicon-o-envelope';

    public static function getNavigationGroup(): ?string
    {
        return __('lang.navigation_groups.content');
    }

    public static function getModelLabel(): string
    {
        return 'Contact Submission';
    }

    public static function getPluralModelLabel(): string
    {
        return 'Contact Submissions';
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Contact Information')
                    ->schema([
                        Forms\Components\Select::make('type')
                            ->options([
                                'contact' => 'General Contact',
                                'property_inquiry' => 'Property Inquiry',
                                'general_inquiry' => 'General Property Inquiry',
                                'mandate' => 'Mandate Request',
                            ])
                            ->required()
                            ->default('contact')
                            ->disabled()
                            ->live(),
                        Forms\Components\Select::make('property_id')
                            ->label('Property')
                            ->relationship('property', 'title')
                            ->searchable()
                            ->preload()
                            ->visible(fn (Forms\Get $get) => $get('type') === 'property_inquiry'),
                        Forms\Components\TextInput::make('name')
                            ->required()
                            ->maxLength(255),
                        Forms\Components\TextInput::make('surname')
                            ->maxLength(255),
                        Forms\Components\TextInput::make('email')
                            ->email()
                            ->required()
                            ->maxLength(255),
                        Forms\Components\TextInput::make('phone')
                            ->tel()
                            ->maxLength(255),
                        Forms\Components\TextInput::make('subject')
                            ->maxLength(255),
                        Forms\Components\Textarea::make('message')
                            ->required()
                            ->rows(5)
                            ->columnSpanFull(),
                    ])
                    ->columns(2),

                Forms\Components\Section::make('Property Preferences')
                    ->schema([
                        Forms\Components\Select::make('city_id')
                            ->label('City')
                            ->relationship('city', 'name')
                            ->searchable()
                            ->preload(),
                        Forms\Components\Select::make('listing_type')
                            ->options([
                                'sale' => 'Sale',
                                'rent' => 'Rent',
                            ]),
                        Forms\Components\Select::make('property_type')
                            ->options([
                                'house' => 'House',
                                'apartment' => 'Apartment',
                                'commercial' => 'Commercial',
                                'land' => 'Land',
                            ]),
                        Forms\Components\TextInput::make('bedrooms')
                            ->numeric()
                            ->minValue(0),
                        Forms\Components\TextInput::make('min_price')
                            ->numeric()
                            ->prefix('€'),
                        Forms\Components\TextInput::make('max_price')
                            ->numeric()
                            ->prefix('€'),
                        Forms\Components\TextInput::make('price')
                            ->label('Price (Mandate)')
                            ->numeric()
                            ->prefix('€')
                            ->visible(fn (Forms\Get $get) => $get('type') === 'mandate'),
                        Forms\Components\TextInput::make('square_meters')
                            ->numeric()
                            ->suffix('m²')
                            ->visible(fn (Forms\Get $get) => $get('type') === 'mandate'),
                    ])
                    ->columns(2)
                    ->visible(fn (Forms\Get $get) => in_array($get('type'), ['general_inquiry', 'mandate']))
                    ->collapsible(),

                Forms\Components\Section::make('Admin')
                    ->schema([
                        Forms\Components\Select::make('status')
                            ->options([
                                'new' => 'New',
                                'read' => 'Read',
                                'replied' => 'Replied',
                            ])
                            ->required()
                            ->default('new'),
                        Forms\Components\Textarea::make('admin_notes')
                            ->rows(3)
                            ->columnSpanFull(),
                        Forms\Components\DateTimePicker::make('read_at')
                            ->native(false),
                        Forms\Components\DateTimePicker::make('replied_at')
                            ->native(false),
                    ])
                    ->columns(2)
                    ->collapsible(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('type')
                    ->badge()
                    ->colors([
                        'primary' => 'contact',
                        'success' => 'property_inquiry',
                        'info' => 'general_inquiry',
                        'warning' => 'mandate',
                    ])
                    ->formatStateUsing(fn (string $state): string => match($state) {
                        'property_inquiry' => 'Property Inquiry',
                        'general_inquiry' => 'General Inquiry',
                        'mandate' => 'Mandate Request',
                        default => 'General Contact',
                    }),
                Tables\Columns\TextColumn::make('property.title')
                    ->label('Property')
                    ->searchable()
                    ->limit(30)
                    ->toggleable(),
                Tables\Columns\TextColumn::make('name')
                    ->searchable()
                    ->sortable()
                    ->formatStateUsing(fn ($record) => $record->surname ? $record->name . ' ' . $record->surname : $record->name),
                Tables\Columns\TextColumn::make('email')
                    ->searchable()
                    ->sortable()
                    ->copyable(),
                Tables\Columns\TextColumn::make('phone')
                    ->searchable()
                    ->toggleable(),
                Tables\Columns\TextColumn::make('city.name')
                    ->label('City')
                    ->toggleable()
                    ->searchable(),
                Tables\Columns\TextColumn::make('listing_type')
                    ->badge()
                    ->toggleable()
                    ->colors([
                        'success' => 'sale',
                        'info' => 'rent',
                    ]),
                Tables\Columns\TextColumn::make('status')
                    ->badge()
                    ->colors([
                        'warning' => 'new',
                        'info' => 'read',
                        'success' => 'replied',
                    ]),
                Tables\Columns\TextColumn::make('created_at')
                    ->label('Received')
                    ->dateTime()
                    ->sortable(),
            ])
            ->defaultSort('created_at', 'desc')
            ->filters([
                Tables\Filters\SelectFilter::make('type')
                    ->options([
                        'contact' => 'General Contact',
                        'property_inquiry' => 'Property Inquiry',
                        'general_inquiry' => 'General Inquiry',
                        'mandate' => 'Mandate Request',
                    ]),
                Tables\Filters\SelectFilter::make('status')
                    ->options([
                        'new' => 'New',
                        'read' => 'Read',
                        'replied' => 'Replied',
                    ]),
                Tables\Filters\SelectFilter::make('listing_type')
                    ->options([
                        'sale' => 'Sale',
                        'rent' => 'Rent',
                    ]),
            ])
            ->actions([
                Tables\Actions\ViewAction::make(),
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListContacts::route('/'),
            'create' => Pages\CreateContact::route('/create'),
            'edit' => Pages\EditContact::route('/{record}/edit'),
        ];
    }
}
