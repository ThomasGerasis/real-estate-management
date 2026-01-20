# Translating Filament Resources

## Translation Files Created

Greek translations: `lang/el/resources.php`
English translations: `lang/en/resources.php`

## How to Use Translations in Your Resources

### 1. Update Navigation Labels

Replace hardcoded strings with translation calls using `__()` helper.

**Before:**
```php
protected static ?string $navigationGroup = 'Properties';
```

**After:**
```php
public static function getNavigationGroup(): ?string
{
    return __('resources.navigation_groups.properties');
}
```

### 2. Update Model Labels

**Before:**
```php
protected static ?string $model = Property::class;
```

**After:**
```php
protected static ?string $model = Property::class;

public static function getModelLabel(): string
{
    return __('resources.property.label');
}

public static function getPluralModelLabel(): string
{
    return __('resources.property.plural_label');
}
```

### 3. Update Section Headings

**Before:**
```php
Forms\Components\Section::make('Basic Information')
```

**After:**
```php
Forms\Components\Section::make(__('resources.property.sections.basic_information'))
```

### 4. Update Field Labels

**Before:**
```php
Forms\Components\TextInput::make('title')
    ->required()
```

**After:**
```php
Forms\Components\TextInput::make('title')
    ->label(__('resources.property.fields.title'))
    ->required()
```

### 5. Update Select Options

**Before:**
```php
Forms\Components\Select::make('type')
    ->options([
        'house' => 'House',
        'apartment' => 'Apartment',
        'commercial' => 'Commercial',
        'land' => 'Land',
    ])
```

**After:**
```php
Forms\Components\Select::make('type')
    ->label(__('resources.property.fields.type'))
    ->options([
        'house' => __('resources.property.types.house'),
        'apartment' => __('resources.property.types.apartment'),
        'commercial' => __('resources.property.types.commercial'),
        'land' => __('resources.property.types.land'),
    ])
```

### 6. Update Table Columns

**Before:**
```php
Tables\Columns\TextColumn::make('title')
    ->searchable()
```

**After:**
```php
Tables\Columns\TextColumn::make('title')
    ->label(__('resources.property.fields.title'))
    ->searchable()
```

## Quick Example: PropertyResource

Add these methods to your PropertyResource class:

```php
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
    return __('resources.navigation_groups.properties');
}
```

Then update form sections and fields:

```php
Forms\Components\Section::make(__('resources.property.sections.basic_information'))
    ->schema([
        Forms\Components\TextInput::make('title')
            ->label(__('resources.property.fields.title'))
            ->required(),
        Forms\Components\Select::make('type')
            ->label(__('resources.property.fields.type'))
            ->options([
                'house' => __('resources.property.types.house'),
                'apartment' => __('resources.property.types.apartment'),
                'commercial' => __('resources.property.types.commercial'),
                'land' => __('resources.property.types.land'),
            ])
            ->required(),
    ])
```

## Apply to All Resources

You need to update:
- PropertyResource
- CityResource
- DistrictResource
- AgentResource
- PostResource
- PageResource
- MenuResource

Follow the same pattern for each resource using the translations in `lang/el/resources.php` and `lang/en/resources.php`.
