<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Property extends Model
{
    protected $fillable = [
        'title',
        'description',
        'agent_id',
        'city_id',
        'district_id',
        'address',
        'postal_code',
        'price',
        'status',
        'type',
        'listing_type',
        'bedrooms',
        'bathrooms',
        'square_meters',
        'year_built',
        'energy_class',
        'garage',
        'images',
        'extra_details',
        'is_featured',
        'published_at',
        'meta_title',
        'meta_description',
    ];

    protected $casts = [
        'price' => 'decimal:2',
        'square_meters' => 'decimal:2',
        'images' => 'array',
        'extra_details' => 'array',
        'is_featured' => 'boolean',
        'published_at' => 'datetime',
    ];

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
            $excerpt = substr(strip_tags($this->description), 0, 100);
            $parts[] = $excerpt;
        }
        
        return implode('. ', $parts);
    }
}
