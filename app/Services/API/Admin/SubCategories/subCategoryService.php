<?php

namespace App\Services\API\Admin\SubCategories;

use App\Http\Requests\API\Admin\SubCategories\StoreSubCategoryRequest;
use App\Http\Requests\API\Admin\SubCategories\UpdateSubCategoryRequest;
use App\Http\Resources\API\Admin\Categories\CategoryListResource;
use App\Http\Resources\API\Admin\SubCategories\SubCategoryEditResource;
use App\Http\Resources\API\Admin\SubCategories\SubCategoryListResource;
use App\Interfaces\API\Admin\SubCategories\subCategoryInterface;
use App\Models\Category;
use App\Models\SubCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class subCategoryService implements subCategoryInterface
{
    public function getAll(Request $request)
    {
        $search = $request->search;
        $category_id = $request->category_id;

        $query = SubCategory::query();

        $query->when($search, function ($q) use ($search) {
            return $q->where('title', 'like', "%{$search}%")
                ->orWhere('slug', 'like', "%{$search}%");
        });

        $query->when($category_id, function ($q) use ($category_id) {
            return $q->whereHas('categories', function ($inner_q) use ($category_id) {
                return $inner_q->where('id', $category_id);
            });
        });

        return  SubCategoryListResource::collection($query->paginate($request->item_per_page));
    }

    public function getAllCategories()
    {
        $categories = Category::all();
        if ($categories) {
            return CategoryListResource::collection(Category::all());
        }
        return response()->json(['message' => 'No Category found'], 200);
    }

    public function store(StoreSubCategoryRequest $request)
    {
        $data = $request->except('categories');
        try {
            if ($request->hasFile('image')) {
                $data['image'] = Storage::disk('public')->put('/', $request->file('image'));
            }
            $sub_category = SubCategory::create($data);
            $sub_category->categories()->attach($request->categories);
            return response()->json(['message' => 'SubCategory Stored Successfully'], 200);
        } catch (\Throwable $th) {
            return response()->json($th->getMessage(), 201);
        }
    }

    public function edit(int $id)
    {
        $subCategory = SubCategory::find($id);
        if ($subCategory) {
            return  new SubCategoryEditResource($subCategory);
        } else {
            return response()->json(['message', 'SubCategory not exist'], 201);
        }
    }

    public function update(UpdateSubCategoryRequest $request, int $id)
    {
        $subCategory = SubCategory::find($id);
        if ($subCategory) {
            $data = [
                'title' => $request->title,
                'slug' => $request->slug,
                'order' => $request->order,
            ];
            if ($request->hasFile('image')) {
                if (Storage::exists($subCategory->image)) {
                    Storage::delete($subCategory->image);
                }
                $data['image'] = Storage::disk('public')->put('/', $request->file('image'));
            }
            $subCategory->update($data);
            $subCategory->categories()->sync($request->categories);
            return response()->json(['message' => 'SubCategory Updated Successfully'], 200);
        } else {
            return response()->json(['message' => 'SubCategory not updated'], 201);
        }
    }

    public function destroy(int $id)
    {
        $subCategory = SubCategory::where('id', $id)->first();

        if ($subCategory) {

            if (Storage::exists($subCategory->image)) {
                Storage::delete($subCategory->image);
            }
            $subCategory->delete();
            return response()->json(['message' => 'SubCategory deleted successfully'], 200);
        } else {
            return response()->json(['message' => 'SubCategory does not exist'], 201);
        }
    }
}
