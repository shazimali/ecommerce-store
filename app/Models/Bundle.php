<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Bundle extends Model
{
    use \Illuminate\Database\Eloquent\Factories\HasFactory;

    protected $fillable = [
        'title',
        'slug',
        'sku',
        'order',
        'short_desc',
        'discount',
        'description',
        'youtube_link',
        'seo_title',
        'seo_desc',
        'status',
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

    public function price_detail(): HasOne
    {
        return $this->hasOne(BundlePrice::class, 'bundle_id', 'id')->where('country_id', getLocation()->id);
    }

    public function scopeActive($query)
    {
        return $query->where('status', 'ACTIVE');
    }

    public function colors(): HasMany
    {
        return $this->hasMany(BundleColor::class, 'bundle_id', 'id');
    }
}
