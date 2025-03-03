<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Banner extends Model
{
    protected $fillable = ['title', 'heading', 'sub_heading', 'btn_text', 'btn_link', 'image', 'mob_image', 'order', 'websites', 'created_at', 'updated_at'];

    public function websites(): BelongsToMany
    {
        return $this->belongsToMany(Website::class, 'banner_website', 'banner_id', 'website_id');
    }
}
