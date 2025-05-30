<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Blog extends Model
{
    protected $fillable = ['title', 'slug', 'image', 'description', 'seo_title', 'seo_desc', 'status',  'created_at', 'updated_at'];

    public function countries(): BelongsToMany
    {
        return $this->belongsToMany(Country::class, 'blog_country', 'blog_id', 'country_id');
    }

    public function scopeActive($query)
    {
        return $query->where('status', 'ACTIVE');
    }
}
