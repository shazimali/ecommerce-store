<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class ProductHead extends Model
{
    protected $fillable = ['title', 'slug', 'code', 'sku', 'order', 'short_desc', 'discount', 'description', 'youtube_link', 'seo_title', 'seo_desc', 'status', 'is_new', 'is_featured', 'coming_soon', 'nav_image', 'mobile_image', 'image', 'created_at', 'updated_at'];

    public function sub_categories(): BelongsToMany
    {
        return $this->belongsToMany(SubCategory::class, 'product_head_sub_category', 'product_head_id', 'sub_category_id');
    }
}
