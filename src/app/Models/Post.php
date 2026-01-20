<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Post extends Model
{
    protected $fillable = [
        'title',
        'slug',
        'content',
        'excerpt',
        'featured_image',
        'status',
        'published_at',
        'meta_title',
        'meta_description',
    ];

    protected $casts = [
        'published_at' => 'datetime',
    ];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($post) {
            if (empty($post->slug)) {
                $post->slug = Str::slug($post->title);
            }
        });
    }

    public function getAutoMetaTitleAttribute(): string
    {
        return $this->title . ' - Real Estate Blog';
    }

    public function getAutoMetaDescriptionAttribute(): string
    {
        if ($this->excerpt) {
            return Str::limit($this->excerpt, 155);
        }
        
        if ($this->content) {
            $text = strip_tags($this->content);
            return Str::limit($text, 155);
        }
        
        return $this->title;
    }
}
