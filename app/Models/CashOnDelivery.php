<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class CashOnDelivery extends Model
{
    protected $fillable = ['title', 'api_test_url', 'api_url', 'api_key', 'api_password', 'status',  'created_at', 'updated_at'];

    public function countries(): BelongsToMany
    {
        return $this->belongsToMany(Country::class, 'cash_on_delivery_country', 'cash_on_delivery_id', 'country_id');
    }

    public function scopeActiveORDefault($query)
    {
        return $query->where('status', 'ACTIVE')->orWhere('status', 'DEFAULT');
    }
}
