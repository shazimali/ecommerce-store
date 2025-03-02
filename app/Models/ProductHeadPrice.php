<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;

class ProductHeadPrice extends Model
{
    protected $fillable = ['product_head_id', 'country_id', 'price', 'discount', 'discount_from', 'discount_to', 'created_at', 'updated_at'];

    function product_head(): HasOne
    {
        return $this->hasOne(ProductHead::class, 'id', 'product_head_id');
    }

    function country(): HasOne
    {
        return $this->hasOne(Country::class, 'id', 'country_id');
    }
}
