<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Post extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'slug',
        'content',
        'excerpt',
        'featured_image',
        'social_card_image',
        'status',
        'views_count',
        'user_id',
        'created_at',
        'updated_at',
    ];

    protected $casts = [
        'views_count' => 'integer',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function categories()
    {
        return $this->belongsToMany(Category::class);
    }

    public function tags()
    {
        return $this->belongsToMany(Tag::class);
    }

    /**
     * Get the featured image URL.
     */
    public function getFeaturedImageUrlAttribute()
    {
        if (empty($this->featured_image)) {
            return asset('images/default-news.jpg');
        }

        if (Str::startsWith($this->featured_image, ['http://', 'https://'])) {
            return $this->featured_image;
        }

        $siteUrl = rtrim(config('services.wordpress.site_url', env('WP_SITE_URL', 'https://www.bholatimes24.com')), '/');
        
        // If it starts with wp-content or similar, prepend WP_SITE_URL
        if (Str::startsWith($this->featured_image, 'wp-content/')) {
            return $siteUrl . '/' . $this->featured_image;
        }

        if (Str::startsWith($this->featured_image, '/wp-content/')) {
            return $siteUrl . $this->featured_image;
        }

        // Custom local uploads
        if (Str::startsWith($this->featured_image, 'uploads/')) {
            return asset($this->featured_image);
        }

        return asset('storage/' . $this->featured_image);
    }

    /**
     * Get the social card image URL.
     */
    public function getSocialCardImageUrlAttribute()
    {
        if (empty($this->social_card_image)) {
            return null;
        }

        if (Str::startsWith($this->social_card_image, ['http://', 'https://'])) {
            return $this->social_card_image;
        }

        return asset($this->social_card_image);
    }

    /**
     * Calculate estimated reading time of the post.
     */
    public function getReadTimeAttribute()
    {
        $wordCount = str_word_count(strip_tags($this->content));
        $minutes = ceil($wordCount / 200); // 200 words per minute average
        return $minutes > 0 ? $minutes : 1;
    }
}
