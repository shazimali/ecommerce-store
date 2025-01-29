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

class subCategoryService implements subCategoryInterface
{
    public function getAll(Request $request)
    {
        $itemsPerPge = $request->get('items_per_page', 10);
        $subCategory = SubCategory::paginate($itemsPerPge);
        if ($subCategory) {
            return SubCategoryListResource::collection($subCategory);
        }
        return response()->json(['message' => 'No SubCategory found'], 200);
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
        // DB::beginTransaction();
        try {
            $subCategory = SubCategory::create($request->all());

            // $subCategory->categories()->attach($request->categories);
            return response()->json(['message' => 'SubCategory Stored Successfully'], 200);

            // if ($subCategory) {

            //     return response()->json(['message' => 'SubCategory Stored Successfully'], 200);
            //     DB::commit();
            // }
        } catch (\Throwable $th) {
            // DB::rollBack();
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
                'image' => $request->image,
                'order' => $request->order,
            ];
            $subCategory->update($data);
            // $subCategory->categories()->sync($request->countries);
            return response()->json(['message' => 'SubCategory Updated Successfully'], 200);
        } else {
            return response()->json(['message' => 'SubCategory not updated'], 201);
        }
    }

    public function destroy(int $id)
    {
        $subCategory = SubCategory::where('id', $id)->first();

        if ($subCategory) {
            $subCategory->delete();
            return response()->json(['message' => 'SubCategory deleted successfully'], 200);
        } else {
            return response()->json(['message' => 'SubCategory does not exist'], 201);
        }
    }
}
