<?php

namespace App\Services\API\Admin\Categories;

use App\Http\Requests\API\Admin\Categories\StoreCategoryRequest;
use App\Http\Requests\API\Admin\Categories\UpdateCategoryRequest;
use App\Http\Resources\API\Admin\Categories\CategoryEditResource;
use App\Http\Resources\API\Admin\Categories\CategoryListResource;
use App\Http\Resources\API\Admin\Countries\CountryListResource;
use App\Http\Resources\API\Admin\Websites\WebsiteListResource;
use App\Interfaces\API\Admin\Categories\CategoryInterface;
use App\Models\Category;
use App\Models\CategoryCountry;
use App\Models\CategoryWebsite;
use App\Models\Country;
use App\Models\Website;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class CategoryService implements CategoryInterface
{
    public function getAll(Request $request)
    {
        $search = $request->search;
        $country_id = $request->country_id;

        $query = Category::query();

        $query->when($search, function ($q) use ($search) {
            return $q->where('title', 'like', "%{$search}%")
                ->orWhere('slug', 'like', "%{$search}%");
        });

        $query->when($country_id, function ($q) use ($country_id) {
            return $q->whereHas('countries', function ($inner_q) use ($country_id) {
                return $inner_q->where('id', $country_id);
            });
        });

        return CategoryListResource::collection($query->paginate($request->item_per_page));
    }

    public function getAllCountries()
    {
        $countries = Country::all();
        if ($countries) {
            return CountryListResource::collection(Country::all());
        }
        return response()->json(['message' => 'No country found'], 201);
    }

    public function getAllWebsites()
    {
        $websites = Website::active()->get();
        if ($websites) {
            return WebsiteListResource::collection($websites);
        }
        return response()->json(['message' => 'No website found'], 201);
    }

    public function store(StoreCategoryRequest $request)
    {
        $data = $request->all();
        try {
            if ($request->hasFile('image')) {
                $data['image'] = Storage::disk('public')->put('/', $request->file('image'));
            }
            $category = Category::create($data);
            $category->websites()->attach($data['websites']);

            return response()->json(['message' => 'Category Stored Successfully'], 200);
        } catch (\Throwable $th) {
            return response()->json($th->getMessage(), 201);
        }
    }

    public function edit(int $id)
    {
        $categories = Category::with('countries')->find($id);
        if ($categories) {
            return  new CategoryEditResource(Category::with('countries')->whereId($id)->first());
        } else {
            return response()->json(['message' => 'Categories not found'], 201);
        }
    }

    public function update(UpdateCategoryRequest $request, int $id)
    {
        $category = Category::find($id);
        if ($category) {
            $data = [
                'title' => $request->title,
                'slug' => $request->slug,
                'order' => $request->order,
            ];
            if ($request->hasFile('image')) {
                if (Storage::exists($category->image)) {
                    Storage::delete($category->image);
                }
                $data['image'] = Storage::disk('public')->put('/', $request->file('image'));
            }
            $category->update($data);
            $category->websites()->sync($request->websites);
            return  response()->json(['message' => 'Category updated successfully.'], 200);
        } else {
            return response()->json(['message' => 'Category not found'], 201);
        }
    }

    public function destroy(int $id)
    {
        $category = Category::with('websites')->whereId($id)->first();
        if ($category) {
            $is_category_attached_with_website = CategoryWebsite::where('website_id', $id)->first();
            if ($is_category_attached_with_website)
                return  response()->json(['message' => 'Category attached with website, can not delete.'], 201);

            $category->delete();
            return  response()->json(['message' => 'Category deleted successfully.'], 200);
        } else {
            return response()->json(['message' => 'Category not found'], 201);
        }
    }
}
