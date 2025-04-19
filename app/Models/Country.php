<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Country extends Model
{

    public function categories(): BelongsToMany
    {
        return $this->belongsToMany(Category::class, 'category_country', 'category_id', 'country_id');
    }

    public function facilities(): BelongsToMany
    {
        return $this->belongsToMany(Facility::class, 'facility_country', 'facility_id', 'country_id');
    }

    public function pages(): BelongsToMany
    {
        return $this->belongsToMany(Page::class, 'page_country', 'country_id', 'page_id');
    }

    public function blogs(): BelongsToMany
    {
        return $this->belongsToMany(Blog::class, 'blog_country', 'blog_id', 'country_id');
    }
}
