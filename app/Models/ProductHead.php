<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Stevebauman\Location\Facades\Location;

class ProductHead extends Model
{
    protected $fillable = [
        'title',
        'slug',
        'code',
        'sku',
        'order',
        'short_desc',
        'discount',
        'description',
        'youtube_link',
        'seo_title',
        'seo_desc',
        'status',
        'is_new',
        'is_featured',
        'coming_soon',
        'nav_image',
        'mobile_image',
        'image',
        'image1',
        'image2',
        'image3',
        'image4',
        'image5',
        'created_at',
        'updated_at'
    ];

    public function sub_categories(): BelongsToMany
    {
        return $this->belongsToMany(SubCategory::class, 'product_head_sub_category', 'product_head_id', 'sub_category_id');
    }

    public function price_detail(): HasOne
    {
        $loc = Location::get('154.192.161.138');
        $country = Country::where('iso', $loc->countryCode)->first();
        return  $this->hasOne(ProductHeadPrice::class, 'product_head_id', 'id')->where('country_id', $country->id);
    }

    public function scopeActive($query)
    {
        return $query->where('status', 'ACTIVE');
    }

    public function scopeFeatured($query)
    {
        return $query->where('is_featured', 1);
    }

    public function scopeNew($query)
    {
        return $query->where('is_new', 1);
    }

    public function colors()
    {
        return $this->hasMany(ProductColor::class, 'product_head_id', 'id');
    }

    public function stocks()
    {
        return $this->hasMany(PurchaseDetail::class, 'product_head_id', 'id');
    }
}
