<?php

namespace App\Services\API\Admin\Products;

use App\Http\Resources\API\Admin\Products\ProductEditResource;
use App\Http\Resources\API\Admin\Products\ProductListResource;
use App\Http\Resources\API\Admin\SubCategories\SubCategoryListResource;
use App\Interfaces\API\Admin\Products\ProductInterface;
use App\Models\ProductColor;
use App\Models\ProductHead;
use App\Models\ProductHeadPrice;
use App\Models\ProductHeadSubCategory;
use App\Models\SubCategory;

class ProductService implements ProductInterface
{
    use \App\Traits\FileUploadTrait;

    public function getAll(array $filters, int $perPage)
    {
        $product = ProductHead::paginate($perPage);
        if ($product) {
            return ProductListResource::collection($product);
        } else {
            return response()->json(['message', 'Product Not exist'], 201);
        }
    }

    public function store(array $data)
    {
        $sub_categories = $data['sub_categories'] ?? [];
        unset($data['sub_categories']);

        $data['is_new'] = ($data['is_new'] ?? false) == true ? 1 : 0;
        $data['is_trending'] = ($data['is_trending'] ?? false) == true ? 1 : 0;
        $data['is_featured'] = ($data['is_featured'] ?? false) == true ? 1 : 0;
        $data['coming_soon'] = ($data['coming_soon'] ?? false) == true ? 1 : 0;

        if (isset($data['image']) && $data['image'] instanceof \Illuminate\Http\UploadedFile) {
            $data['image'] = $this->uploadFile($data['image']);
            $data['nav_image'] = $this->createThumbnailFromPath($data['image'], 208, 208);
        }
        
        foreach (range(1, 5) as $i) {
            $key = "image$i";
            if (isset($data[$key]) && $data[$key] instanceof \Illuminate\Http\UploadedFile) {
                $data[$key] = $this->uploadFile($data[$key]);
            }
        }

        $product = ProductHead::create($data);
        $product->sub_categories()->attach($sub_categories);
        
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

    public function update(int $id, array $data)
    {
        $product = ProductHead::find($id);
        if (!$product) {
            return response()->json(['message' => 'Product not found'], 201);
        }

        $sub_categories = $data['sub_categories'] ?? [];
        unset($data['sub_categories']);

        $data['is_new'] = ($data['is_new'] ?? 'false') == 'true' ? 1 : 0;
        $data['is_featured'] = ($data['is_featured'] ?? 'false') == 'true' ? 1 : 0;
        $data['is_trending'] = ($data['is_trending'] ?? 'false') == 'true' ? 1 : 0;
        $data['coming_soon'] = ($data['coming_soon'] ?? 'false') == 'true' ? 1 : 0;

        if (isset($data['image']) && $data['image'] instanceof \Illuminate\Http\UploadedFile) {
            $this->deleteFile($product->image);
            $this->deleteFile($product->nav_image);

            $data['image'] = $this->uploadFile($data['image']);
            $data['nav_image'] = $this->createThumbnailFromPath($data['image'], 208, 208);
        }

        foreach (range(1, 5) as $i) {
            $key = "image$i";
            if (isset($data[$key]) && $data[$key] instanceof \Illuminate\Http\UploadedFile) {
                $this->deleteFile($product->$key);
                $data[$key] = $this->uploadFile($data[$key]);
            }
        }

        $product->update($data);
        $product->sub_categories()->sync($sub_categories);
        
        return response()->json(['message' => 'Product Updated Successfully'], 200);
    }

    public function destroy(int $id)
    {
        $product = ProductHead::find($id);
        if ($product) {
            $is_sub_category_attached = ProductHeadSubCategory::where('product_head_id', $id)->first();
            if ($is_sub_category_attached)
                return  response()->json(['message' => 'Product attached with sub category, can not delete.'], 201);

            $this->deleteFile($product->image);
            $this->deleteFile($product->image1);
            $this->deleteFile($product->image2);
            $this->deleteFile($product->image3);
            $this->deleteFile($product->image4);
            $this->deleteFile($product->image5);
            $this->deleteFile($product->nav_image);

            //Deleting related product colors
            $productColors = ProductColor::where('product_head_id', $id)->get();
            if (count($productColors)) {
                foreach ($productColors  as $key => $product_color) {
                    $this->deleteFile($product_color->color_image);
                    $this->deleteFile($product_color->image1);
                    $this->deleteFile($product_color->image2);
                    $this->deleteFile($product_color->image3);
                    $this->deleteFile($product_color->image4);
                    $this->deleteFile($product_color->image5);
                }
            }
            //Deleting related product prices
            $productPrices = ProductHeadPrice::where('product_head_id', $id)->get();
            if ($productPrices) {
                foreach ($productPrices as $key => $product_price) {
                    $product_price->delete();
                }
            }
            //Deleting product
            $product->delete();
            return response()->json(['message' => 'Product deleted successfully'], 200);
        } else {
            return response()->json(['message' => 'Product not found'], 201);
        }
    }

    public function getAllSubCategories()
    {
        return SubCategoryListResource::collection(SubCategory::all());
    }
}
