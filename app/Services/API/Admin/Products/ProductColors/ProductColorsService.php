<?php

namespace App\Services\API\Admin\Products\ProductColors;

use App\Http\Requests\API\Admin\Products\ProductColors\StoreProductColorsRequest;
use App\Http\Requests\API\Admin\Products\ProductColors\UpdateProductColorsRequest;
use App\Http\Resources\API\Admin\Products\ProductColors\ProductColorsEditResource;
use App\Http\Resources\API\Admin\Products\ProductColors\ProductColorsListResource;
use App\Interfaces\API\Admin\Products\ProductColors\ProductColorsInterface;
use App\Models\ProductColor;
use Illuminate\Support\Facades\Storage;

class ProductColorsService implements ProductColorsInterface
{
    public function getAll(int $id)
    {
        $productColor = ProductColor::where('product_head_id', $id)->get();
        if ($productColor) {
            return ProductColorsListResource::collection($productColor);
        } else {
            return response()->json(['message', 'Product Color Not exist'], 201);
        }
    }

    public function store(StoreProductColorsRequest $request)
    {
        $data['product_head_id'] = $request->product_head_id;
        $data['color_name'] = $request->color_name;
        if ($request->hasFile('color_image')) {
            $data['color_image'] = Storage::disk('public')->put('/', $request->file('color_image'));
        }
        if ($request->hasFile('image1')) {
            $data['image1'] = Storage::disk('public')->put('/', $request->file('image1'));
        }
        if ($request->hasFile('image2')) {
            $data['image2'] = Storage::disk('public')->put('/', $request->file('image2'));
        }
        if ($request->hasFile('image3')) {
            $data['image3'] = Storage::disk('public')->put('/', $request->file('image3'));
        }
        if ($request->hasFile('image4')) {
            $data['image4'] = Storage::disk('public')->put('/', $request->file('image4'));
        }
        if ($request->hasFile('image5')) {
            $data['image5'] = Storage::disk('public')->put('/', $request->file('image5'));
        }
        $productColor = ProductColor::create($data);
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
            if (Storage::exists($productColor->color_image)) {
                Storage::delete($productColor->color_image);
            }
            if (Storage::exists($productColor->image1)) {
                Storage::delete($productColor->image1);
            }
            if (Storage::exists($productColor->image2)) {
                Storage::delete($productColor->image2);
            }
            if (Storage::exists($productColor->image3)) {
                Storage::delete($productColor->image3);
            }
            if (Storage::exists($productColor->image4)) {
                Storage::delete($productColor->image4);
            }
            if (Storage::exists($productColor->image5)) {
                Storage::delete($productColor->image5);
            }
            $productColor->delete();
            return response()->json(['message' => 'Product Color Deleted Successfully'], 200);
        } else {
            return response()->json(['message' => 'Product not found'], 201);
        }
    }
}
