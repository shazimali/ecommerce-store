<?php

namespace App\Http\Controllers;

use App\Models\SubCategory;
use Illuminate\Http\Request;

class SubCategoriesController extends Controller
{
    public function productsBySubCategorySlug(string $slug)
    {
        $sub_category = SubCategory::where('slug', $slug)->with('product_heads')->first();
        if ($sub_category) {
            $products = $sub_category->product_heads;
            return view('sub_categories', [
                'products' => $products,
                'sub_category_title' => $sub_category->title,
            ]);
        }
        return abort('404');
    }
}
