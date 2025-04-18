<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;

class OrderDetail extends Model
{
    /**
     * Get the user associated with the OrderDetail
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function product(): HasOne
    {
        return $this->hasOne(ProductHead::class, 'id', 'product_id');
    }

    /**
     * Get the user associated with the OrderDetail
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function color(): HasOne
    {
        return $this->hasOne(ProductColor::class, 'id', 'color_id');
    }
}
