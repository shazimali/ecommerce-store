<?php

namespace App\Services\API\Admin\Products;

use App\Http\Requests\API\Admin\Products\StoreProductRequest;
use App\Http\Requests\API\Admin\Products\UpdateProductRequest;
use App\Http\Resources\API\Admin\Products\ProductEditResource;
use App\Http\Resources\API\Admin\Products\ProductListResource;
use App\Interfaces\API\Admin\Products\ProductInterface;
use App\Models\ProductHead;
use Illuminate\Http\Request;

class ProductService implements ProductInterface
{
    public function getAll(Request $request)
    {
        $itemsPerPage = $request->get('items_per_page', 10);
        $product = ProductHead::paginate($itemsPerPage);
        if ($product) {
            return ProductListResource::collection($product);
        } else {
            return response()->json(['message', 'Product Not exist'], 201);
        }
    }

    public function store(StoreProductRequest $request)
    {
        $product = ProductHead::create($request->all());
        if ($product) {
            return response()->json(['message' => 'Product Stored Successfully '], 200);
        } else {
            return response()->json(['message' => 'Product Not Stored'], 201);
        }
    }

    public function edit(int $id)
    {
        $product = ProductHead::find($id);
        if ($product) {
            return new ProductEditResource($product);
        } else {
            return response()->json(['message', 'Product not exist'], 201);
        }
    }

    public function update(UpdateProductRequest $request, int $id)
    {
        $product = ProductHead::find($id);
        if ($product) {
            $data = [
                'title' => $request->title,
                'slug' => $request->slug,
                'code' => $request->code,
                'sku' => $request->sku,
                'order' => $request->order,
                'short_desc' => $request->short_desc,
                'discount' => $request->discount,
                'description' => $request->description,
                'youtube_link' => $request->youtube_link,
                'seo_title' => $request->seo_title,
                'seo_desc' => $request->seo_desc,
                'status' => $request->status,
                // 'is_new' => $request->is_new,
                // 'is_featured' => $request->is_featured,
                // 'coming_soon' => $request->coming_soon,
                // 'nav_image' => $request->nav_image,
                // 'mobile_image' => $request->mobile_image,
                'image' => $request->image,
            ];
            $product->update($data);
            return response()->json(['message', 'Product Updated Successfully'], 200);
        } else {
            return response()->json(['message', 'Product Not Updated'], 201);
        }
    }

    public function destroy(int $id)
    {
        $product = ProductHead::find($id);
        if ($product) {
            $product->delete();
            return response()->json(['message', 'Product Deleted Successfully'], 200);
        } else {
            return response()->json(['message', 'Product not found'], 201);
        }
    }
}
