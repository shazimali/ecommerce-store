<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;

class ProductReview extends Model
{
    protected $fillable = ['product_id', 'user_id', 'rating', 'review', 'image1', 'image2', 'image3', 'status', 'created_at', 'updated_at'];

    /**
     * Get the user associated with the ProductReview
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function product(): HasOne
    {
        return $this->hasOne(ProductHead::class, 'id', 'product_id');
    }

    public function user(): HasOne
    {
        return $this->hasOne(User::class, 'id', 'user_id');
    }

    // public function order(): HasOne
    // {
    //     return $this->hasOne(Order::class, 'id', 'order_id');
    // }
}
