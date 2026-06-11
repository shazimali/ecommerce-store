<?php

namespace App\Services;

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
        return  ProductHead::where('slug', $slug)->with('stocks', 'colors', 'sub_categories')->first();
    }

    static public function getProductReviews(int $id)
    {
        return  ProductReview::where('product_id', $id)->with('user')->get();
    }
}
