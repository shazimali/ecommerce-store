<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;

class BundleColor extends Model
{
    protected $fillable = [
        'bundle_id',
        'color_name',
        'color_image',
        'image1',
        'image2',
        'image3',
        'image4',
        'image5',
        'created_at',
        'updated_at'
    ];

    public function bundle(): HasOne
    {
        return $this->hasOne(Bundle::class, 'id', 'bundle_id');
    }
}
