<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Badge extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'image',
        'status',
    ];

    public function sub_categories(): BelongsToMany
    {
        return $this->belongsToMany(SubCategory::class, 'badge_sub_category', 'badge_id', 'sub_category_id');
    }
}
