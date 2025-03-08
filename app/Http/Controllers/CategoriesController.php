<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;

class CategoriesController extends Controller
{
    public function SubCategoriesByCategorySlug(string $slug)
    {
        $category = Category::where('slug', $slug)->first();
        if ($category) {
            $subCategories = $category->sub_categories;
            return view('categories', [
                'subCategories' => $subCategories,
                'category_title' => $category->title,
            ]);
        }
        return abort('404');
    }
}
