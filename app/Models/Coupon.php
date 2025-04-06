<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Coupon extends Model
{
    protected $fillable = ['title', 'code', 'discount', 'date_from', 'date_to', 'country_id', 'created_at', 'updated_at'];

    /**
     * Get the Country associated with the Setting
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function Country(): HasOne
    {
        return $this->hasOne(Country::class, 'id', 'country_id');
    }
}
