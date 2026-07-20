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
use Illuminate\Support\Facades\DB;
use Illuminate\Http\UploadedFile;

class ProductService implements ProductInterface
{
    use \App\Traits\FileUploadTrait;

    public function getAll(array $filters, int $perPage)
    {
        $products = ProductHead::with(['sub_categories', 'price_detail', 'colors'])->paginate($perPage);
        return ProductListResource::collection($products);
    }

    public function store(array $data)
    {
        $subCategories = $data['sub_categories'] ?? [];
        unset($data['sub_categories']);

        $data['is_new'] = filter_var($data['is_new'] ?? false, FILTER_VALIDATE_BOOLEAN) ? 1 : 0;
        $data['is_trending'] = filter_var($data['is_trending'] ?? false, FILTER_VALIDATE_BOOLEAN) ? 1 : 0;
        $data['is_featured'] = filter_var($data['is_featured'] ?? false, FILTER_VALIDATE_BOOLEAN) ? 1 : 0;
        $data['coming_soon'] = filter_var($data['coming_soon'] ?? false, FILTER_VALIDATE_BOOLEAN) ? 1 : 0;

        if (isset($data['image']) && $data['image'] instanceof UploadedFile) {
            $data['image'] = $this->uploadFile($data['image']);
            $data['nav_image'] = $this->createThumbnailFromPath($data['image'], 208, 208);
        }
        
        foreach (range(1, 5) as $i) {
            $key = "image$i";
            if (isset($data[$key]) && $data[$key] instanceof UploadedFile) {
                $data[$key] = $this->uploadFile($data[$key]);
            }
        }

        return DB::transaction(function () use ($data, $subCategories) {
            $product = ProductHead::create($data);
            if (!empty($subCategories)) {
                $product->sub_categories()->attach($subCategories);
            }
            return response()->json(['message' => 'Product Stored Successfully '], 200);
        });
    }

    public function edit(int $id)
    {
        $product = ProductHead::with(['sub_categories', 'price_detail', 'colors'])->find($id);
        if ($product) {
            return new ProductEditResource($product);
        }
        return response()->json(['message' => 'Product not exist'], 201);
    }

    public function update(int $id, array $data)
    {
        $product = ProductHead::find($id);
        if (!$product) {
            return response()->json(['message' => 'Product not found'], 201);
        }

        $subCategories = $data['sub_categories'] ?? [];
        unset($data['sub_categories']);

        $data['is_new'] = filter_var($data['is_new'] ?? false, FILTER_VALIDATE_BOOLEAN) ? 1 : 0;
        $data['is_featured'] = filter_var($data['is_featured'] ?? false, FILTER_VALIDATE_BOOLEAN) ? 1 : 0;
        $data['is_trending'] = filter_var($data['is_trending'] ?? false, FILTER_VALIDATE_BOOLEAN) ? 1 : 0;
        $data['coming_soon'] = filter_var($data['coming_soon'] ?? false, FILTER_VALIDATE_BOOLEAN) ? 1 : 0;

        if (isset($data['image']) && $data['image'] instanceof UploadedFile) {
            $this->deleteFile($product->image);
            $this->deleteFile($product->nav_image);

            $data['image'] = $this->uploadFile($data['image']);
            $data['nav_image'] = $this->createThumbnailFromPath($data['image'], 208, 208);
        }

        foreach (range(1, 5) as $i) {
            $key = "image$i";
            if (isset($data[$key]) && $data[$key] instanceof UploadedFile) {
                $this->deleteFile($product->$key);
                $data[$key] = $this->uploadFile($data[$key]);
            }
        }

        return DB::transaction(function () use ($product, $data, $subCategories) {
            $product->update($data);
            $product->sub_categories()->sync($subCategories);
            return response()->json(['message' => 'Product Updated Successfully'], 200);
        });
    }

    public function destroy(int $id)
    {
        $product = ProductHead::find($id);
        if (!$product) {
            return response()->json(['message' => 'Product not found'], 201);
        }

        $is_sub_category_attached = ProductHeadSubCategory::where('product_head_id', $id)->first();
        if ($is_sub_category_attached) {
            return response()->json(['message' => 'Product attached with sub category, can not delete.'], 201);
        }

        return DB::transaction(function () use ($product, $id) {
            $this->deleteMultipleFiles([
                $product->image,
                $product->image1,
                $product->image2,
                $product->image3,
                $product->image4,
                $product->image5,
                $product->nav_image,
            ]);

            // Deleting related product colors
            $productColors = ProductColor::where('product_head_id', $id)->get();
            foreach ($productColors as $product_color) {
                $this->deleteMultipleFiles([
                    $product_color->color_image,
                    $product_color->image1,
                    $product_color->image2,
                    $product_color->image3,
                    $product_color->image4,
                    $product_color->image5,
                ]);
                $product_color->delete();
            }

            // Deleting related product prices
            ProductHeadPrice::where('product_head_id', $id)->delete();

            // Deleting product
            $product->delete();
            return response()->json(['message' => 'Product deleted successfully'], 200);
        });
    }

    public function getAllSubCategories()
    {
        return SubCategoryListResource::collection(SubCategory::all());
    }
}

