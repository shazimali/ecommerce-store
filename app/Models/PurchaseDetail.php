<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;


class PurchaseDetail extends Model
{
    protected $fillable = [ 'purchase_id', 'product_head_id', 'product_color_id', 'qty','net_price',
       'created_at', 'updated_at',
    ];
}
