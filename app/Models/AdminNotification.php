<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AdminNotification extends Model
{
    protected $fillable = [
        'description',
        'is_read',
        'user_id',
        'created_at',
        'updated_at'
    ];

    public function scopeUnread($query)
    {
        return $query->where('is_Read', 'false');
    }
}
