<?php

namespace App\services;

use App\Models\ProductHead;
use App\Models\ProductReview;

class ProductService
{
    /**
     * Create a new class instance.
     */
    public function __construct()
    {
        //
    }

    static public function getProductDetailBySlug(string $slug)
    {
        return  ProductHead::where('slug', $slug)->with('stocks', 'colors')->first();
    }

    static public function getProductReviews(int $id)
    {
        return  ProductReview::Where('product_id', $id)->get();
    }
}
