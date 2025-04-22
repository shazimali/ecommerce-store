<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

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
}
