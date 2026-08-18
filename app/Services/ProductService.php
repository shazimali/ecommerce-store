<?php

namespace App\Services;

use App\Models\ProductHead;
use App\Models\ProductReview;
use Illuminate\Support\Facades\Cache;

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
        return Cache::remember('product_detail_' . $slug, now()->addMinutes(30), function () use ($slug) {
            return ProductHead::where('slug', $slug)
                ->with('stocks', 'colors', 'sub_categories', 'price_detail')
                ->first();
        });
    }

    static public function getProductReviews(int $id)
    {
        return Cache::remember('product_reviews_' . $id, now()->addMinutes(15), function () use ($id) {
            return ProductReview::where('product_id', $id)->with('user')->get();
        });
    }
}
