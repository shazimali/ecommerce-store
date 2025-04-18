<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\ProductColor;
use App\Models\ProductHead;
use App\Models\ProductReview;
use Illuminate\Http\Request;

class ProductsController extends Controller
{
    public function detail($slug)
    {
        $product = ProductHead::whereSlug($slug)->first();
        $reviews = ProductReview::where('product_id', $product->id)->get();
        if ($product) {
            return view('products.detail', [
                'product' => $product,
                'reviews' => $reviews,
            ]);
        }
        return abort('404'); // 404 Not Found
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
