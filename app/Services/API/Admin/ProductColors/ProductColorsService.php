<?php

namespace App\Services\API\Admin\ProductColors;

use App\Http\Requests\API\Admin\ProductColors\StoreProductColorRequest;
use App\Http\Requests\API\Admin\ProductColors\UpdateProductColorRequest;
use App\Http\Resources\API\Admin\ProductColors\ProductColorEditResource;
use App\Http\Resources\API\Admin\ProductColors\ProductColorListResource;
use App\Interfaces\API\Admin\ProductColors\ProductColorInterface;
use App\Models\ProductColor;
use Illuminate\Http\Request;

class ProductColorsService implements ProductColorInterface
{

    public function getAll(Request $request)
    {
        $itemsPerPage = $request->get('items_per_page', 10);
        $productColor = ProductColor::paginate($itemsPerPage);
        if ($productColor) {
            return ProductColorListResource::collection($productColor);
        } else {
            return response()->json(['message', 'Product Color Not exist'], 201);
        }
    }

    public function store(StoreProductColorRequest $request)
    {
        $productColor = ProductColor::create($request->all());
        if ($productColor) {
            return response()->json(['message' => 'Product Color Stored Successfully '], 200);
        } else {
            return response()->json(['message' => 'Product Color Not Store'], 201);
        }
    }

    public function edit(int $id)
    {
        $productColor = ProductColor::find($id);
        if ($productColor) {
            return new ProductColorEditResource($productColor);
        } else {
            return response()->json(['message' => 'Product Color not exist'], 201);
        }
    }

    public function update(UpdateProductColorRequest $request, int $id)
    {
        $productColor = ProductColor::find($id);
        if ($productColor) {
            $data = [
                'product_head_id' => $request->product_head_id,
                'color_name' => $request->color_name,
                'color_image' => $request->color_image,
                'image1' => $request->image1,
                'image2' => $request->image2,
                'image3' => $request->image3,
                'image4' => $request->image4,
                'image5' => $request->image5,

            ];
            $productColor->update($data);
            return  response()->json(['message' => 'Product Color updated successfully.'], 200);
        } else {
            return response()->json(['message' => 'Product Color not found'], 201);
        }
    }

    public function destroy(int $id)
    {
        $productColor = ProductColor::find($id);
        if ($productColor) {
            $productColor->delete();
            return response()->json(['message' => 'Product Color Deleted Successfully'], 200);
        } else {
            return response()->json(['message' => 'Product not found'], 201);
        }
    }
}
