<?php

namespace App\Services\API\Admin\Products\ProductColors;

use App\Http\Requests\API\Admin\Products\ProductColors\StoreProductColorsRequest;
use App\Http\Requests\API\Admin\Products\ProductColors\UpdateProductColorsRequest;
use App\Http\Resources\API\Admin\Products\ProductColors\ProductColorsEditResource;
use App\Http\Resources\API\Admin\Products\ProductColors\ProductColorsListResource;
use App\Interfaces\API\Admin\Products\ProductColors\ProductColorsInterface;
use App\Models\ProductColor;
use Illuminate\Http\Request;

class ProductColorsService implements ProductColorsInterface
{
    public function getAll(Request $request, int $id)
    {
        $productColor = ProductColor::where('product_head_id', $id)->paginate($request->items_per_page);
        if ($productColor) {
            return ProductColorsListResource::collection($productColor);
        } else {
            return response()->json(['message', 'Product Color Not exist'], 201);
        }
    }

    public function store(StoreProductColorsRequest $request)
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
            return new ProductColorsEditResource($productColor);
        } else {
            return response()->json(['message' => 'Product Color not exist'], 201);
        }
    }

    public function update(UpdateProductColorsRequest $request, int $id)
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
