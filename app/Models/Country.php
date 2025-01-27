<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Country extends Model
{

    public function categories(): BelongsToMany
    {
        return $this->belongsToMany(Category::class, 'category_country', 'category_id', 'country_id');
    }
}
