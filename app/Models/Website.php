<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Website extends Model
{
    protected $fillable = ['title', 'domain', 'phone', 'phone1', 'address', 'logo', 'news', 'email', 'status', 'order', 'wel_msg', 'about', 'created_at', 'updated_at'];
}
