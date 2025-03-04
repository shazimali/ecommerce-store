<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Facility extends Model
{
    protected $fillable = ['title', 'class', 'created_at', 'updated_at'];

    public function countries(): BelongsToMany
    {
        return $this->belongsToMany(Country::class, 'facility_country', 'country_id', 'facility_id');
    }
}
