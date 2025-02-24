<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Category extends Model
{

    protected $fillable = ['title', 'slug', 'image', 'order', 'created_at', 'updated_at'];

    public function countries(): BelongsToMany
    {
        return $this->belongsToMany(Country::class, 'category_country', 'category_id', 'country_id');
    }

    public function websites(): BelongsToMany
    {
        return $this->belongsToMany(Website::class, 'category_website', 'category_id', 'website_id');
    }

    public function sub_categories(): BelongsToMany
    {
        return $this->belongsToMany(SubCategory::class, 'category_sub_category', 'category_id', 'sub_category_id');
    }
}
