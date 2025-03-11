<?php

namespace App\Http\Controllers;

use App\Models\ProductHead;
use Illuminate\Http\Request;

class ProductsController extends Controller
{
    public function detail($slug)
    {
        $product = ProductHead::whereSlug($slug)->first();
        if ($product) {
            return view('products.detail', compact('product'));
        }
        return abort('404'); // 404 Not Found
    }
}
