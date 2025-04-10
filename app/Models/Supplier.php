<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Supplier extends Model
{

    protected $fillable = ['name', 'email', 'address', 'phone', 'created_at', 'updated_at'];
}
