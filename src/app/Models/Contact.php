<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Contact extends Model
{
    protected $fillable = [
        'type',
        'property_id',
        'city_id',
        'name',
        'surname',
        'email',
        'phone',
        'subject',
        'message',
        'listing_type',
        'property_type',
        'bedrooms',
        'min_price',
        'max_price',
        'price',
        'square_meters',
        'status',
        'admin_notes',
        'read_at',
        'replied_at',
    ];

    protected $casts = [
        'read_at' => 'datetime',
        'replied_at' => 'datetime',
        'price' => 'decimal:2',
        'min_price' => 'decimal:2',
        'max_price' => 'decimal:2',
        'square_meters' => 'decimal:2',
    ];

    public function property(): BelongsTo
    {
        return $this->belongsTo(Property::class);
    }

    public function city(): BelongsTo
    {
        return $this->belongsTo(City::class);
    }
}
