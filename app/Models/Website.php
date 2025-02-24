<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Website extends Model
{
    protected $fillable = ['title', 'domain', 'phone', 'phone1', 'address', 'logo', 'news', 'email', 'status', 'order', 'wel_msg', 'about', 'created_at', 'updated_at'];


    public function categories(): BelongsToMany
    {
        return $this->belongsToMany(Category::class, 'category_website', 'category_id', 'website_id');
    }

    public function scopeActive($query)
    {
        return $query->where('status', 'ACTIVE');
    }
}
