<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Website extends Model
{
    protected $fillable = ['title', 'domain', 'phone', 'phone1', 'address', 'logo', 'news', 'email', 'status', 'order', 'wel_msg', 'about', 'created_at', 'updated_at'];


    public function categories(): BelongsToMany
    {
        return $this->belongsToMany(Category::class, 'category_website', 'website_id', 'category_id');
    }

    public function banners(): BelongsToMany
    {
        return $this->belongsToMany(Banner::class, 'banner_website', 'website_id', 'banner_id');
    }

    public function social_medias(): BelongsToMany
    {
        return $this->belongsToMany(SocialMedia::class, 'social_media_website', 'website_id', 'social_media_id');
    }

    public function scopeActive($query)
    {
        return $query->where('status', 'ACTIVE');
    }

    function websites(): BelongsToMany
    {
        return $this->belongsToMany(SocialMedia::class, 'social_media_website', 'social_media_id', 'website_id');
    }
}
