<?php

namespace App\Filament\Resources;

use App\Filament\Resources\PropertyResource\Pages;
use App\Filament\Resources\PropertyResource\RelationManagers;
use App\Models\Property;
use Dotswan\MapPicker\Fields\Map;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class PropertyResource extends Resource
{
    protected static ?string $model = Property::class;

    protected static ?string $navigationIcon = 'heroicon-o-home';

    public static function getModelLabel(): string
    {
        return __('resources.property.label');
    }

    public static function getPluralModelLabel(): string
    {
        return __('resources.property.plural_label');
    }

    public static function getNavigationGroup(): ?string
    {
        return __('lang.navigation_groups.properties');
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make(__('resources.property.sections.basic_information'))
                    ->schema([
                        Forms\Components\TextInput::make('title')
                            ->label(__('resources.property.fields.title'))
                            ->required()
                            ->maxLength(255)
                            ->columnSpanFull(),
                        Forms\Components\Textarea::make('description')
                            ->label(__('resources.property.fields.description'))
                            ->rows(4)
                            ->columnSpanFull(),
                        Forms\Components\Select::make('type')
                            ->label(__('resources.property.fields.type'))
                            ->options([
                                'house' => __('resources.property.types.house'),
                                'apartment' => __('resources.property.types.apartment'),
                                'commercial' => __('resources.property.types.commercial'),
                                'land' => __('resources.property.types.land'),
                            ])
                            ->required()
                            ->default('apartment'),
                        Forms\Components\Select::make('listing_type')
                            ->label(__('resources.property.fields.listing_type'))
                            ->options([
                                'sale' => __('resources.property.listing_types.sale'),
                                'rent' => __('resources.property.listing_types.rent'),
                            ])
                            ->required()
                            ->default('sale')
                            ->live()
                            ->helperText('Is this property for sale or for rent?'),
                        Forms\Components\Select::make('status')
                            ->label(__('resources.property.fields.status'))
                            ->options([
                                'available' => __('resources.property.statuses.available'),
                                'sold' => __('resources.property.statuses.sold'),
                                'rented' => __('resources.property.statuses.rented'),
                                'pending' => __('resources.property.statuses.pending'),
                            ])
                            ->required()
                            ->default('available'),
                        Forms\Components\Select::make('publish_status')
                            ->label(__('resources.property.fields.publish_status'))
                            ->options([
                                'draft' => __('resources.property.publish_statuses.draft'),
                                'published' => __('resources.property.publish_statuses.published'),
                            ])
                            ->required()
                            ->default('published')
                            ->helperText('Draft properties are hidden from the public site/API.'),
                        Forms\Components\TextInput::make('price')
                            ->label(__('resources.property.fields.price'))
                            ->required()
                            ->numeric()
                            ->prefix('€')
                            ->suffix(fn(Forms\Get $get) => $get('listing_type') === 'rent' ? '/month' : '')
                            ->helperText(
                                fn(Forms\Get $get) =>
                                $get('listing_type') === 'rent'
                                    ? 'Monthly rent price'
                                    : 'Total sale price'
                            )
                            ->maxValue(99999999.99),
                        Forms\Components\Select::make('agent_id')
                            ->label(__('resources.property.fields.agent'))
                            ->relationship('agent', 'name')
                            ->searchable()
                            ->preload(),
                    ])
                    ->columns(2),

                Forms\Components\Section::make(__('resources.property.sections.location'))
                    ->schema([
                        Forms\Components\Select::make('city_id')
                            ->label(__('resources.property.fields.city'))
                            ->relationship('city', 'name')
                            ->searchable()
                            ->preload()
                            ->live(),
                        Forms\Components\Select::make('district_id')
                            ->label(__('resources.property.fields.district'))
                            ->relationship(
                                'district',
                                'name',
                                fn(Builder $query, Forms\Get $get) =>
                                $query->where('city_id', $get('city_id'))
                            )
                            ->searchable()
                            ->preload()
                            ->live(),
                        Forms\Components\Select::make('subdistrict_id')
                            ->label(__('resources.property.fields.subdistrict'))
                            ->options(fn(Forms\Get $get) => \App\Models\Subdistrict::where('district_id', $get('district_id'))
                                ->where('is_active', true)
                                ->orderBy('name')
                                ->pluck('name', 'id'))
                            ->searchable()
                            ->placeholder('-'),
                        Map::make('location')
                            ->label(__('resources.property.fields.location_map'))
                            ->columnSpanFull()
                            ->defaultLocation(latitude: 37.9838, longitude: 23.7275)
                            ->draggable()
                            ->zoom(13)
                            ->tilesUrl('https://tile.openstreetmap.org/{z}/{x}/{y}.png')
                            ->afterStateHydrated(function (Forms\Set $set, Forms\Get $get, $record) {
                                if ($record) {
                                    $set('location', ['lat' => $record->latitude, 'lng' => $record->longitude]);
                                }
                            })
                            ->afterStateUpdated(function (Forms\Set $set, ?array $state) {
                                $set('latitude', $state['lat'] ?? null);
                                $set('longitude', $state['lng'] ?? null);
                            }),
                        Forms\Components\Hidden::make('latitude'),
                        Forms\Components\Hidden::make('longitude'),
                    ])
                    ->columns(3),

                Forms\Components\Section::make(__('resources.property.sections.features'))
                    ->schema([
                        Forms\Components\TextInput::make('square_meters')
                            ->label(__('resources.property.fields.area'))
                            ->numeric()
                            ->suffix('m²')
                            ->maxValue(99999.99),
                        Forms\Components\TextInput::make('floor')
                            ->label(__('resources.property.fields.floor'))
                            ->numeric()
                            ->helperText('Floor number (e.g. 0 for ground floor, -1 for basement).'),
                        Forms\Components\TextInput::make('bedrooms')
                            ->label(__('resources.property.fields.bedrooms'))
                            ->numeric()
                            ->minValue(0)
                            ->maxValue(100),
                        Forms\Components\TextInput::make('bathrooms')
                            ->label(__('resources.property.fields.bathrooms'))
                            ->numeric()
                            ->minValue(0)
                            ->maxValue(100),
                        Forms\Components\Select::make('garage_type')
                            ->label(__('resources.property.fields.garage_type'))
                            ->options([
                                'open'        => __('resources.property.garage_types.open'),
                                'pilotis'     => __('resources.property.garage_types.pilotis'),
                                'underground' => __('resources.property.garage_types.underground'),
                                'closed'      => __('resources.property.garage_types.closed'),
                                'spots'       => __('resources.property.garage_types.spots'),
                            ])
                            ->placeholder('-'),
                        Forms\Components\TextInput::make('garage')
                            ->label(__('resources.property.fields.garage'))
                            ->numeric()
                            ->default(0)
                            ->minValue(0)
                            ->maxValue(10),
                        Forms\Components\TextInput::make('year_built')
                            ->label(__('resources.property.fields.year_built'))
                            ->numeric()
                            ->minValue(1800)
                            ->maxValue(date('Y') + 5),
                        Forms\Components\Select::make('energy_class')
                            ->options([
                                'A+' => 'A+',
                                'A' => 'A',
                                'B' => 'B',
                                'C' => 'C',
                                'D' => 'D',
                                'E' => 'E',
                                'F' => 'F',
                                'G' => 'G',
                            ]),
                        Forms\Components\Toggle::make('elevator')
                            ->label(__('resources.property.fields.elevator'))
                            ->inline(false),
                        Forms\Components\Select::make('heating_type')
                            ->label(__('resources.property.fields.heating_type'))
                            ->options([
                                'central'    => __('resources.property.heating_types.central'),
                                'autonomous' => __('resources.property.heating_types.autonomous'),
                                'none'       => __('resources.property.heating_types.none'),
                            ])
                            ->placeholder('-'),
                        Forms\Components\Select::make('heating_fuel')
                            ->label(__('resources.property.fields.heating_fuel'))
                            ->options([
                                'gas'        => __('resources.property.heating_fuels.gas'),
                                'oil'        => __('resources.property.heating_fuels.oil'),
                                'electric'   => __('resources.property.heating_fuels.electric'),
                                'heat_pump'  => __('resources.property.heating_fuels.heat_pump'),
                                'other'      => __('resources.property.heating_fuels.other'),
                            ])
                            ->placeholder('-'),
                        Forms\Components\Toggle::make('fireplace')
                            ->label(__('resources.property.fields.fireplace'))
                            ->inline(false),
                        Forms\Components\Toggle::make('furnished')
                            ->label(__('resources.property.fields.furnished'))
                            ->inline(false),
                        Forms\Components\Select::make('property_position')
                            ->label(__('resources.property.fields.property_position'))
                            ->options([
                                'front'    => __('resources.property.property_positions.front'),
                                'interior' => __('resources.property.property_positions.interior'),
                                'corner'   => __('resources.property.property_positions.corner'),
                                'through'  => __('resources.property.property_positions.through'),
                            ])
                            ->placeholder('-'),
                        Forms\Components\Select::make('property_condition')
                            ->label(__('resources.property.fields.property_condition'))
                            ->options([
                                'new'               => __('resources.property.property_conditions.new'),
                                'renovated'         => __('resources.property.property_conditions.renovated'),
                                'excellent'         => __('resources.property.property_conditions.excellent'),
                                'needs_renovation'  => __('resources.property.property_conditions.needs_renovation'),
                            ])
                            ->placeholder('-'),
                        Forms\Components\TextInput::make('floor_type')
                            ->label(__('resources.property.fields.floor_type'))
                            ->maxLength(255),

                    ])
                    ->columns(3),

                Forms\Components\Section::make(__('resources.property.sections.additional_information'))
                    ->schema([
                        Forms\Components\KeyValue::make('extra_details')
                            ->label('Additional Information')
                            ->keyLabel('Detail Name')
                            ->valueLabel('Value')
                            ->addActionLabel('Add Detail')
                            ->helperText('Add any additional property details as key-value pairs (e.g., Balcony: Yes, Pet Friendly: No, etc.)')
                            ->columnSpanFull(),
                    ])
                    ->collapsed()
                    ->collapsible(),

                Forms\Components\Section::make(__('resources.property.sections.images'))
                    ->schema([
                        Forms\Components\FileUpload::make('featured_image')
                            ->label('Featured Image')
                            ->helperText('Main image shown in property listings and cards')
                            ->image()
                            ->disk('public')
                            ->directory('properties')
                            ->imageEditor()
                            ->maxSize(2048)
                            ->columnSpanFull(),
                        Forms\Components\FileUpload::make('images')
                            ->label(__('resources.property.fields.images'))
                            ->helperText('Additional images for property gallery')
                            ->multiple()
                            ->image()
                            ->disk('public')
                            ->directory('properties')
                            ->imageEditor()
                            ->maxFiles(10)
                            ->reorderable()
                            ->columnSpanFull(),
                        Forms\Components\Toggle::make('is_featured')
                            ->label(__('resources.property.fields.featured'))
                            ->default(false),
                        Forms\Components\DateTimePicker::make('published_at')
                            ->label(__('resources.property.fields.published'))
                            ->native(false),
                    ])
                    ->columns(2),

                Forms\Components\Section::make('SEO')
                    ->schema([
                        Forms\Components\Placeholder::make('auto_meta_info')
                            ->label('Auto-Generated Preview')
                            ->content(
                                fn(?Property $record) =>
                                $record
                                    ? "Title: {$record->auto_meta_title}\n\nDescription: {$record->auto_meta_description}"
                                    : 'Save the property first to see auto-generated SEO preview'
                            )
                            ->columnSpanFull(),
                        Forms\Components\TextInput::make('meta_title')
                            ->label('SEO Title')
                            ->maxLength(60)
                            ->placeholder(
                                fn(Forms\Get $get) =>
                                $get('title')
                                    ? $get('title') . ' - ' . ($get('city_id') ? 'City' : '') . ' - ' . ($get('listing_type') === 'rent' ? 'For Rent' : 'For Sale')
                                    : 'Auto-generated from property details'
                            )
                            ->helperText('Leave blank to use auto-generated title. Max 60 characters recommended.')
                            ->columnSpanFull(),
                        Forms\Components\Textarea::make('meta_description')
                            ->label('SEO Description')
                            ->rows(3)
                            ->maxLength(160)
                            ->placeholder('Auto-generated from property details, location, price, and description')
                            ->helperText('Leave blank to use auto-generated description. Max 160 characters recommended.')
                            ->columnSpanFull(),
                    ])
                    ->collapsed()
                    ->collapsible(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\ImageColumn::make('featured_image')
                    ->label('Image')
                    ->disk('public')
                    ->square(),
                Tables\Columns\TextColumn::make('title')
                    ->label(__('resources.property.fields.title'))
                    ->searchable()
                    ->sortable()
                    ->limit(30),
                Tables\Columns\TextColumn::make('listing_type')
                    ->label(__('resources.property.fields.listing_type'))
                    ->badge()
                    ->colors([
                        'success' => 'sale',
                        'info' => 'rent',
                    ])
                    ->formatStateUsing(fn(string $state): string => __('resources.property.listing_types.' . $state)),
                Tables\Columns\TextColumn::make('type')
                    ->label(__('resources.property.fields.type'))
                    ->badge()
                    ->colors([
                        'primary' => 'apartment',
                        'success' => 'house',
                        'warning' => 'commercial',
                        'info' => 'land',
                    ])
                    ->formatStateUsing(fn(string $state): string => __('resources.property.types.' . $state)),
                Tables\Columns\TextColumn::make('price')
                    ->label(__('resources.property.fields.price'))
                    ->money('EUR')
                    ->sortable(),
                Tables\Columns\TextColumn::make('status')
                    ->label(__('resources.property.fields.status'))
                    ->badge()
                    ->colors([
                        'success' => 'available',
                        'danger' => 'sold',
                        'warning' => 'rented',
                        'info' => 'pending',
                    ])
                    ->formatStateUsing(fn(string $state): string => __('resources.property.statuses.' . $state)),
                Tables\Columns\TextColumn::make('publish_status')
                    ->label(__('resources.property.fields.publish_status'))
                    ->badge()
                    ->colors([
                        'gray' => 'draft',
                        'success' => 'published',
                    ])
                    ->formatStateUsing(fn(string $state): string => __('resources.property.publish_statuses.' . $state)),
                Tables\Columns\TextColumn::make('city.name')
                    ->label(__('resources.property.fields.city'))
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('square_meters')
                    ->label(__('resources.property.fields.area'))
                    ->suffix(' m²')
                    ->sortable(),
                Tables\Columns\TextColumn::make('bedrooms')
                    ->label(__('resources.property.fields.bedrooms'))
                    ->sortable(),
                Tables\Columns\TextColumn::make('energy_class')
                    ->badge(),
                Tables\Columns\TextColumn::make('agent.name')
                    ->label(__('resources.property.fields.agent'))
                    ->searchable()
                    ->toggleable(),
                Tables\Columns\IconColumn::make('is_featured')
                    ->label(__('resources.property.fields.featured'))
                    ->boolean()
                    ->toggleable(),
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('listing_type')
                    ->options([
                        'sale' => __('resources.property.listing_types.sale'),
                        'rent' => __('resources.property.listing_types.rent'),
                    ])
                    ->label(__('resources.property.fields.listing_type')),
                Tables\Filters\SelectFilter::make('type')
                    ->label(__('resources.property.fields.type'))
                    ->options([
                        'house' => __('resources.property.types.house'),
                        'apartment' => __('resources.property.types.apartment'),
                        'commercial' => __('resources.property.types.commercial'),
                        'land' => __('resources.property.types.land'),
                    ]),
                Tables\Filters\SelectFilter::make('status')
                    ->label(__('resources.property.fields.status'))
                    ->options([
                        'available' => __('resources.property.statuses.available'),
                        'sold' => __('resources.property.statuses.sold'),
                        'rented' => __('resources.property.statuses.rented'),
                        'pending' => __('resources.property.statuses.pending'),
                    ]),
                Tables\Filters\SelectFilter::make('publish_status')
                    ->label(__('resources.property.fields.publish_status'))
                    ->options([
                        'draft' => __('resources.property.publish_statuses.draft'),
                        'published' => __('resources.property.publish_statuses.published'),
                    ]),
                Tables\Filters\SelectFilter::make('city')
                    ->label(__('resources.property.fields.city'))
                    ->relationship('city', 'name'),
                Tables\Filters\TernaryFilter::make('is_featured')
                    ->label(__('resources.property.fields.featured')),
                Tables\Filters\SelectFilter::make('energy_class')
                    ->options([
                        'A+' => 'A+',
                        'A' => 'A',
                        'B' => 'B',
                        'C' => 'C',
                        'D' => 'D',
                        'E' => 'E',
                        'F' => 'F',
                        'G' => 'G',
                    ]),
            ])
            ->actions([
                Tables\Actions\Action::make('view_frontend')
                    ->label('View on Frontend')
                    ->icon('heroicon-o-arrow-top-right-on-square')
                    ->url(fn(Property $record): string => $record->frontend_url)
                    ->openUrlInNewTab()
                    ->visible(fn(Property $record): bool => $record->published_at !== null && $record->publish_status === 'published'),
                Tables\Actions\ViewAction::make(),
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ])
            ->defaultSort('created_at', 'desc');
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
            'index' => Pages\ListProperties::route('/'),
            'create' => Pages\CreateProperty::route('/create'),
            'edit' => Pages\EditProperty::route('/{record}/edit'),
        ];
    }
}
