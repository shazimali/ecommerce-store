<?php

namespace App\Http\Controllers;

use App\Models\SubCategory;
use Illuminate\Http\Request;

class SubCategoriesController extends Controller
{
    public function productsBySubCategorySlug(string $slug)
    {
        $sub_category = SubCategory::where('slug', $slug)->with('product_heads', 'categories')->first();
        if ($sub_category) {
            $categoryIds = $sub_category->categories->pluck('id')->toArray();
            if (!empty($categoryIds) && !in_array(session('current_category_id'), $categoryIds)) {
                session(['current_category_id' => $categoryIds[0]]);
            }
            $products = $sub_category->product_heads;
            return view('sub_categories', [
                'products' => $products,
                'sub_category_title' => $sub_category->title,
            ]);
        }
        return abort('404');
    }
}
