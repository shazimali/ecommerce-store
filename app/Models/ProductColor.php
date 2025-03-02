<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;

class ProductColor extends Model
{
    function product_head(): HasOne
    {
        return $this->hasOne(ProductHead::class, 'id', 'product_head_id');
    }
}
