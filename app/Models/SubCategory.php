<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class SubCategory extends Model
{

    protected $fillable = ['title', 'slug', 'image', 'order', 'categories', 'created_at', 'updated_at'];

    public function categories(): BelongsToMany
    {
        return $this->belongsToMany(Category::class, 'category_sub_category', 'category_id', 'sub_category_id');
    }

    public function product_heads(): BelongsToMany
    {
        return $this->belongsToMany(ProductHead::class, 'product_head_sub_category', 'sub_category_id', 'product_head_id');
    }
}
