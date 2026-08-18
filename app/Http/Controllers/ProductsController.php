<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\ProductColor;
use App\Models\ProductHead;
use App\Models\ProductReview;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class ProductsController extends Controller
{
    public function detail($slug)
    {
        $product = Cache::remember('product_detail_' . $slug, now()->addMinutes(30), function () use ($slug) {
            return ProductHead::whereSlug($slug)
                ->with('colors', 'sub_categories', 'price_detail')
                ->first();
        });

        if (!$product) {
            return abort(404);
        }

        $reviews = Cache::remember('product_reviews_' . $product->id, now()->addMinutes(15), function () use ($product) {
            return ProductReview::where('product_id', $product->id)->with('user')->get();
        });

        return view('products.detail', [
            'product' => $product,
            'reviews' => $reviews,
        ]);
    }

    public function shop()
    {
        $products = ProductHead::orderBy('order', 'ASC')->paginate(4);
        $categories = Category::all();
        $colors = ProductColor::distinct()->select('color_name')->get();
        return view('shop', [
            'products' => $products,
            'categories' => $categories,
            'colors' => $colors
        ]);
    }
}
