<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProductHead extends Model
{
    protected $fillable = ['title', 'slug', 'code', 'sku', 'order', 'short_desc', 'discount', 'description', 'youtube_link', 'seo_title', 'seo_desc', 'status', 'is_new', 'is_featured', 'coming_soon', 'nav_image', 'mobile_image', 'image'];
}
