<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Property extends Model
{
    protected $fillable = [
        'title',
        'description',
        'featured_image',
        'agent_id',
        'city_id',
        'district_id',
        'subdistrict_id',
        'price',
        'status',
        'publish_status',
        'type',
        'listing_type',
        'bedrooms',
        'bathrooms',
        'square_meters',
        'year_built',
        'energy_class',
        'garage',
        'elevator',
        'heating_type',
        'heating_fuel',
        'fireplace',
        'furnished',
        'property_position',
        'property_condition',
        'floor_type',
        'floor',
        'garage_type',
        'images',
        'extra_details',
        'is_featured',
        'published_at',
        'meta_title',
        'meta_description',
        'latitude',
        'longitude',
    ];

    protected $casts = [
        'price' => 'decimal:2',
        'square_meters' => 'decimal:2',
        'floor' => 'integer',
        'images' => 'array',
        'extra_details' => 'array',
        'elevator' => 'boolean',
        'fireplace' => 'boolean',
        'furnished' => 'boolean',
        'is_featured' => 'boolean',
        'published_at' => 'datetime',
        'latitude' => 'decimal:7',
        'longitude' => 'decimal:7',
    ];

    public function subdistrict(): BelongsTo
    {
        return $this->belongsTo(Subdistrict::class);
    }

    public function agent(): BelongsTo
    {
        return $this->belongsTo(Agent::class);
    }

    public function city(): BelongsTo
    {
        return $this->belongsTo(City::class);
    }

    public function district(): BelongsTo
    {
        return $this->belongsTo(District::class);
    }

    public function getAutoMetaTitleAttribute(): string
    {
        $parts = [$this->title];
        
        if ($this->city) {
            $parts[] = $this->city->name;
        }
        
        $listingType = $this->listing_type === 'rent' ? 'For Rent' : 'For Sale';
        $parts[] = $listingType;
        
        return implode(' - ', $parts);
    }

    public function getAutoMetaDescriptionAttribute(): string
    {
        $parts = [];
        
        // Type and location
        $type = ucfirst($this->type);
        $parts[] = "{$type} {$this->listing_type}";
        
        if ($this->city) {
            $parts[] = "in {$this->city->name}";
        }
        
        // Price
        if ($this->listing_type === 'rent') {
            $parts[] = "€" . number_format($this->price, 0) . "/month";
        } else {
            $parts[] = "€" . number_format($this->price, 0);
        }
        
        // Details
        $details = [];
        if ($this->bedrooms) {
            $details[] = "{$this->bedrooms} bed";
        }
        if ($this->bathrooms) {
            $details[] = "{$this->bathrooms} bath";
        }
        if ($this->square_meters) {
            $details[] = "{$this->square_meters}m²";
        }
        
        if (!empty($details)) {
            $parts[] = implode(', ', $details);
        }
        
        // Description excerpt
        if ($this->description) {
            $excerpt = mb_substr(strip_tags($this->description), 0, 100);
            $parts[] = $excerpt;
        }
        
        return implode('. ', $parts);
    }

    public function getFrontendUrlAttribute(): string
    {
        $baseUrl = rtrim(config('app.frontend_url'), '/');
        return $baseUrl . '/properties/' . $this->id;
    }

    public function getProcessedDescriptionAttribute(): string
    {
        return process_shortcodes($this->description ?? '');
    }
}
