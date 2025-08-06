<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Collection extends Model
{
    protected $fillable = [
        'title',
        'slug',
        'status',
        'image',
        'mob_image',
        'order',
        'position',
        'created_at',
        'updated_at'
    ];

    public function websites(): BelongsToMany
    {
        return $this->belongsToMany(Website::class, 'collection_website', 'collection_id', 'website_id');
    }

    public function products(): BelongsToMany
    {
        return $this->belongsToMany(ProductHead::class, 'collection_product_head', 'collection_id', 'product_head_id');
    }

    public function scopeActive($query)
    {
        return $query->where('status', 'ACTIVE');
    }

    public function scopeTop($query)
    {
        return $query->where('position', 'TOP');
    }

    public function scopeStart($query)
    {
        return $query->where('position', 'START');
    }

    public function scopeBottom($query)
    {
        return $query->where('position', 'BOTTOM');
    }
}
