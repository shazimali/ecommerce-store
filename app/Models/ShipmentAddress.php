<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ShipmentAddress extends Model
{
    protected $fillable = [
        'user_id',
        'country_id',
        'city_id',
        'address',
        'phone',
        'created_at',
        'updated_at'
    ];
}
