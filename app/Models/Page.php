<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Page extends Model
{
    protected $table = 'custom_pages';

    protected $fillable = ['title', 'slug', 'content',  'seo_title', 'seo_description', 'status', 'position',  'created_at', 'updated_at'];

    public function countries(): BelongsToMany
    {
        return $this->belongsToMany(Country::class, 'page_country', 'page_id', 'country_id');
    }

    public function scopeActive($query)
    {
        return $query->where('status', 'ACTIVE');
    }

    public function scopeHeader($query)
    {
        return $query->where('position', 'HEADER');
    }

    public function scopeFooter($query)
    {
        return $query->where('position', 'FOOTER');
    }
}
