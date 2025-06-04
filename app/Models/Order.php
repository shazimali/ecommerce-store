<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\SoftDeletes;

class Order extends Model
{
    use SoftDeletes;
    protected $fillable = [
        'order_id',
        'email',
        'sub_total',
        'total',
        'address',
        'billing_address',
        'country_id',
        'city_id',
        'phone',
        'free_shipping',
        'shipping_charges',
        'weight',
        'piece',
        'special_instructions',
        'track_number',
        'slip_link',
        'coupon_id',
        'cod_id',
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
        return $this->hasOne(Coupon::class, 'id', 'coupon_id');
    }

    /**
     * Get the user associated with the Order
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function user(): HasOne
    {
        return $this->hasOne(User::class, 'id', 'user_id');
    }

    public function detail(): HasMany
    {
        return $this->hasMany(OrderDetail::class, 'order_id', 'id');
    }

    public function city(): HasOne
    {
        return $this->hasOne(City::class, 'id', 'city_id');
    }

    public function country(): HasOne
    {
        return $this->hasOne(Country::class, 'id', 'country_id');
    }

     public function cod(): HasOne
    {
        return $this->hasOne(CashOnDelivery::class, 'id', 'cod_id');
    }
}
