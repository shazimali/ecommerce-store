<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Order extends Model
{
    protected $fillable = [
        'order_id',
        'email',
        'sub_total',
        'total',
        'free_shipping',
        'shipping_charges',
        'coupon_id',
        'status',
        'user_id'
    ];

    /**
     * Get the user associated with the Order
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function coupon(): HasOne
    {
        return $this->hasOne(Coupon::class, 'coupon_id', 'id');
    }

    /**
     * Get the user associated with the Order
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function user(): HasOne
    {
        return $this->hasOne(User::class, 'user_id', 'id');
    }
}
