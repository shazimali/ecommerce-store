<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class SubCategory extends Model
{

    protected $fillable = ['title', 'slug', 'image', 'order', 'created_at', 'updated_at'];

    public function categories(): BelongsToMany
    {
        return $this->belongsToMany(Category::class, 'category_sub_category', 'category_id', 'sub_category_id');
    }
}
