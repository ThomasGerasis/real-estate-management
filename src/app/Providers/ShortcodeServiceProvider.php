<?php

namespace App\Providers;

use App\Services\ShortcodeProcessor;
use App\Models\Property;
use App\Models\Faq;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;

class ShortcodeServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->app->singleton(ShortcodeProcessor::class, function ($app) {
            return new ShortcodeProcessor();
        });
    }

    public function boot(): void
    {
        $processor = $this->app->make(ShortcodeProcessor::class);

        // Register [properties] shortcode
        $processor->register('properties', function ($attributes) {
            $limit = $attributes['limit'] ?? 6;
            $type = $attributes['type'] ?? null;
            $listingType = $attributes['listing_type'] ?? null;
            $featured = isset($attributes['featured']) ? filter_var($attributes['featured'], FILTER_VALIDATE_BOOLEAN) : null;

            $query = Property::query()->whereNotNull('published_at');

            if ($type) {
                $query->where('type', $type);
            }

            if ($listingType) {
                $query->where('listing_type', $listingType);
            }

            if ($featured !== null) {
                $query->where('is_featured', $featured);
            }

            $properties = $query->orderBy('created_at', 'desc')->limit($limit)->get();

            return view('shortcodes.properties', compact('properties'))->render();
        });

        // Register [contact_form] shortcode
        $processor->register('contact_form', function ($attributes) {
            $title = $attributes['title'] ?? 'Contact Us';
            
            return view('shortcodes.contact-form', compact('title'))->render();
        });

        // Register [faq] shortcode
        $processor->register('faq', function ($attributes) {
            $category = $attributes['category'] ?? null;
            $limit = $attributes['limit'] ?? null;

            $query = Faq::query()->where('is_active', true);

            if ($category) {
                $query->where('category', $category);
            }

            $query->orderBy('sort_order', 'asc');

            if ($limit) {
                $query->limit($limit);
            }

            $faqs = $query->get();

            return view('shortcodes.faq', compact('faqs', 'category'))->render();
        });
    }
}

