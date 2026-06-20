<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;

class BundlePrice extends Model
{
    use \Illuminate\Database\Eloquent\Factories\HasFactory;

    protected $fillable = [
        'bundle_id',
        'country_id',
        'price',
        'discount',
        'discount_from',
        'discount_to',
        'created_at',
        'updated_at'
    ];

    public function bundle(): HasOne
    {
        return $this->hasOne(Bundle::class, 'id', 'bundle_id');
    }

    public function country(): HasOne
    {
        return $this->hasOne(Country::class, 'id', 'country_id');
    }
}
