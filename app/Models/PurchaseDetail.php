<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class PurchaseDetail extends Model
{
    protected $fillable = [
        'purchase_id',
        'product_head_id',
        'product_color_id',
        'qty',
        'net_price',
        'created_at',
        'updated_at',
    ];

    /**
     * Get the user associated with the PurchaseDetail
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function product(): HasOne
    {
        return $this->hasOne(ProductHead::class, 'id', 'product_head_id');
    }

    /**
     * Get the user associated with the PurchaseDetail
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function color(): HasOne
    {
        return $this->hasOne(ProductColor::class, 'id', 'product_color_id');
    }
}
