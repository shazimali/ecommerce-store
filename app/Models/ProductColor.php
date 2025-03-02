<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;

class ProductColor extends Model
{
    protected $fillable = ['product_head_id', 'color_name', 'color_image', 'image1', 'image2', 'image3', 'image4', 'image5',  'created_at', 'updated_at'];

    function product_head(): HasOne
    {
        return $this->hasOne(ProductHead::class, 'id', 'product_head_id');
    }
}
