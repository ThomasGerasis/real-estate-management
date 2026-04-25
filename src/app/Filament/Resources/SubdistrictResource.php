<?php

namespace App\Filament\Resources;

use App\Filament\Resources\SubdistrictResource\Pages;
use App\Models\City;
use App\Models\District;
use App\Models\Subdistrict;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;

class SubdistrictResource extends Resource
{
    protected static ?string $model = Subdistrict::class;

    protected static ?string $navigationIcon = 'heroicon-o-map-pin';

    protected static ?int $navigationSort = 3;

    public static function getModelLabel(): string
    {
        return __('resources.subdistrict.label');
    }

    public static function getPluralModelLabel(): string
    {
        return __('resources.subdistrict.plural_label');
    }

    public static function getNavigationGroup(): ?string
    {
        return __('lang.navigation_groups.properties');
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make()
                    ->schema([
                        Forms\Components\Select::make('city_id')
                            ->label(__('resources.subdistrict.fields.city'))
                            ->options(fn () => City::where('is_active', true)->orderBy('name')->pluck('name', 'id'))
                            ->required()
                            ->searchable()
                            ->live()
                            ->dehydrated(false)
                            ->afterStateHydrated(function (Forms\Set $set, Forms\Get $get, ?Subdistrict $record) {
                                if ($record?->district) {
                                    $set('city_id', $record->district->city_id);
                                }
                            }),
                        Forms\Components\Select::make('district_id')
                            ->label(__('resources.subdistrict.fields.district'))
                            ->options(fn (Forms\Get $get) => District::where('city_id', $get('city_id'))
                                ->where('is_active', true)
                                ->orderBy('name')
                                ->pluck('name', 'id'))
                            ->required()
                            ->searchable(),
                        Forms\Components\TextInput::make('name')
                            ->label(__('resources.subdistrict.fields.name'))
                            ->required()
                            ->maxLength(255),
                        Forms\Components\TextInput::make('postal_code')
                            ->label(__('resources.subdistrict.fields.postal_code'))
                            ->maxLength(255),
                        Forms\Components\Toggle::make('is_active')
                            ->default(true)
                            ->required(),
                    ])
                    ->columns(2),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('district.city.name')
                    ->label(__('resources.subdistrict.fields.city'))
                    ->sortable()
                    ->searchable(),
                Tables\Columns\TextColumn::make('district.name')
                    ->label(__('resources.subdistrict.fields.district'))
                    ->sortable()
                    ->searchable(),
                Tables\Columns\TextColumn::make('name')
                    ->label(__('resources.subdistrict.fields.name'))
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('postal_code')
                    ->label(__('resources.subdistrict.fields.postal_code'))
                    ->searchable(),
                Tables\Columns\IconColumn::make('is_active')
                    ->boolean(),
                Tables\Columns\TextColumn::make('properties_count')
                    ->counts('properties')
                    ->label(__('resources.subdistrict.fields.properties_count')),
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->defaultSort('name')
            ->filters([
                Tables\Filters\SelectFilter::make('district')
                    ->label(__('resources.subdistrict.fields.district'))
                    ->relationship('district', 'name'),
                Tables\Filters\TernaryFilter::make('is_active'),
            ])
            ->actions([
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
        return [];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListSubdistricts::route('/'),
            'create' => Pages\CreateSubdistrict::route('/create'),
            'edit' => Pages\EditSubdistrict::route('/{record}/edit'),
        ];
    }
}
