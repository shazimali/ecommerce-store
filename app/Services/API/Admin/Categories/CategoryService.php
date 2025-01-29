<?php

namespace App\Services\API\Admin\Categories;

use App\Http\Requests\API\Admin\Categories\StoreCategoryRequest;
use App\Http\Requests\API\Admin\Categories\UpdateCategoryRequest;
use App\Http\Resources\API\Admin\Categories\CategoryEditResource;
use App\Http\Resources\API\Admin\Categories\CategoryListResource;
use App\Http\Resources\API\Admin\Countries\CountryListResource;
use App\Interfaces\API\Admin\Categories\CategoryInterface;
use App\Models\Category;
use App\Models\CategoryCountry;
use App\Models\Country;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

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

        return response()->json([
            'categories' => CategoryListResource::collection($query->paginate($request->item_per_page)),
            'countries' => Country::all()
        ]);
    }

    public function getAllCountries()
    {
        $countries = Country::all();
        if ($countries) {
            return CountryListResource::collection(Country::all());
        }
        return response()->json(['message' => 'No countries found'], 200);
    }

    public function store(StoreCategoryRequest $request)
    {
        DB::beginTransaction();
        try {
            $category = Category::create($request->except('countries'));
            $category->countries()->attach($request->countries);
            DB::commit();
            return response()->json(['message' => 'Categories Stored Successfully'], 200);
        } catch (\Throwable $th) {
            DB::rollBack();
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
        $categories = Category::find($id);
        if ($categories) {
            $data = [
                'title' => $request->title,
                'slug' => $request->slug,
                'image' => $request->image,
                'order' => $request->order,
            ];
            $categories->update($data);
            $categories->countries()->sync($request->countries);
            return  response()->json(['message' => 'Categories updated successfully.'], 200);
        } else {
            return response()->json(['message' => 'Category not found'], 201);
        }
    }

    public function destroy(int $id)
    {
        $categories = Category::with('countries')->whereId($id)->first();
        if ($categories) {
            $is_category_attached_with_country = CategoryCountry::where('category_id', $id)->first();
            if ($is_category_attached_with_country)
                return  response()->json(['message' => 'Category attached with country, can not delete.'], 201);

            $categories->delete();
            return  response()->json(['message' => 'Category deleted successfully.'], 200);
        } else {
            return response()->json(['message' => 'Categories not found'], 201);
        }
    }
}
