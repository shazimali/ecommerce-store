<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Setting extends Model
{
    protected $fillable = ['title', 'key', 'value', 'country_id', 'created_at', 'updated_at'];

    /**
     * Get the Country associated with the Setting
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function Country(): BelongsTo
    {
        return $this->belongsTo(Country::class, 'country_id', 'id');
    }
}
