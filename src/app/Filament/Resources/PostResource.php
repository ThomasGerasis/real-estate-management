<?php

namespace App\Filament\Resources;

use App\Filament\Resources\PostResource\Pages;
use App\Filament\Resources\PostResource\RelationManagers;
use App\Models\Post;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class PostResource extends Resource
{
    protected static ?string $model = Post::class;

    protected static ?string $navigationIcon = 'heroicon-o-newspaper';

    public static function getModelLabel(): string
    {
        return __('resources.post.label');
    }

    public static function getPluralModelLabel(): string
    {
        return __('resources.post.plural_label');
    }

    public static function getNavigationGroup(): ?string
    {
        return __('resources.navigation_groups.content');
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make()
                    ->schema([
                        Forms\Components\TextInput::make('title')
                            ->label(__('resources.post.fields.title'))
                            ->required()
                            ->live(onBlur: true)
                            ->maxLength(255)
                            ->columnSpanFull(),
                        Forms\Components\TextInput::make('slug')
                            ->label(__('resources.post.fields.slug'))
                            ->maxLength(255)
                            ->disabled()
                            ->dehydrated()
                            ->unique(ignoreRecord: true),
                        Forms\Components\Select::make('status')
                            ->label(__('resources.post.fields.status'))
                            ->options([
                                'draft' => __('resources.post.statuses.draft'),
                                'published' => __('resources.post.statuses.published'),
                            ])
                            ->default('draft')
                            ->required(),
                        Forms\Components\DateTimePicker::make('published_at')
                            ->label(__('resources.post.fields.published_at'))
                            ->native(false),
                    ])
                    ->columns(3),

                Forms\Components\Section::make(__('resources.post.fields.content'))
                    ->schema([
                        Forms\Components\Textarea::make('excerpt')
                            ->label(__('resources.post.fields.excerpt'))
                            ->rows(3)
                            ->maxLength(500)
                            ->columnSpanFull(),
                        Forms\Components\RichEditor::make('content')
                            ->label(__('resources.post.fields.content'))
                            ->columnSpanFull()
                            ->fileAttachmentsDirectory('posts'),
                    ]),

                Forms\Components\Section::make(__('resources.post.fields.featured_image'))
                    ->schema([
                        Forms\Components\FileUpload::make('featured_image')
                            ->label(__('resources.post.fields.featured_image'))
                            ->image()
                            ->directory('posts')
                            ->imageEditor()
                            ->maxSize(2048),
                    ])
                    ->collapsible(),

                Forms\Components\Section::make('SEO')
                    ->schema([
                        Forms\Components\Placeholder::make('auto_meta_info')
                            ->label('Auto-Generated Preview')
                            ->content(fn (?Post $record) => 
                                $record 
                                    ? "Title: {$record->auto_meta_title}\n\nDescription: {$record->auto_meta_description}" 
                                    : 'Save the post first to see auto-generated SEO preview'
                            )
                            ->columnSpanFull(),
                        Forms\Components\TextInput::make('meta_title')
                            ->label('SEO Title')
                            ->maxLength(60)
                            ->placeholder(fn (Forms\Get $get) => 
                                $get('title') 
                                    ? $get('title') . ' - Real Estate Blog' 
                                    : 'Auto-generated from post title'
                            )
                            ->helperText('Leave blank to use auto-generated title. Max 60 characters recommended.')
                            ->columnSpanFull(),
                        Forms\Components\Textarea::make('meta_description')
                            ->label('SEO Description')
                            ->rows(3)
                            ->maxLength(160)
                            ->placeholder('Auto-generated from excerpt or content')
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
                    ->label(__('resources.post.fields.featured_image')),
                Tables\Columns\TextColumn::make('title')
                    ->label(__('resources.post.fields.title'))
                    ->searchable()
                    ->sortable()
                    ->limit(40),
                Tables\Columns\TextColumn::make('status')
                    ->label(__('resources.post.fields.status'))
                    ->badge()
                    ->colors([
                        'warning' => 'draft',
                        'success' => 'published',
                    ])
                    ->formatStateUsing(fn (string $state): string => __('resources.post.statuses.' . $state)),
                Tables\Columns\TextColumn::make('published_at')
                    ->label(__('resources.post.fields.published_at'))
                    ->dateTime()
                    ->sortable()
                    ->toggleable(),
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('status')
                    ->label(__('resources.post.fields.status'))
                    ->options([
                        'draft' => __('resources.post.statuses.draft'),
                        'published' => __('resources.post.statuses.published'),
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
            'index' => Pages\ListPosts::route('/'),
            'create' => Pages\CreatePost::route('/create'),
            'edit' => Pages\EditPost::route('/{record}/edit'),
        ];
    }
}
