<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class SocialMedia extends Model
{
    protected $table = 'social_medias';
    protected $fillable = ['title', 'class', 'url', 'websites', 'created_at', 'updated_at'];

    function websites(): BelongsToMany
    {
        return $this->belongsToMany(Website::class, 'social_media_website', 'social_media_id', 'website_id');
    }
}
