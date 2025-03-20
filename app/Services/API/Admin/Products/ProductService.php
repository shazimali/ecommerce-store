<?php

namespace App\Services\API\Admin\Products;

use App\Http\Requests\API\Admin\Products\StoreProductPriceRequest;
use App\Http\Requests\API\Admin\Products\StoreProductRequest;
use App\Http\Requests\API\Admin\Products\UpdateProductPriceRequest;
use App\Http\Requests\API\Admin\Products\UpdateProductRequest;
use App\Http\Resources\API\Admin\Countries\CountryListResource;
use App\Http\Resources\API\Admin\Products\ProductEditResource;
use App\Http\Resources\API\Admin\Products\ProductListResource;
use App\Http\Resources\API\Admin\Products\ProductPricesEditResource;
use App\Http\Resources\API\Admin\Products\ProductPricesListResource;
use App\Http\Resources\API\Admin\SubCategories\SubCategoryListResource;
use App\Interfaces\API\Admin\Products\ProductInterface;
use App\Models\Country;
use App\Models\ProductColor;
use App\Models\ProductHead;
use App\Models\ProductHeadPrice;
use App\Models\ProductHeadSubCategory;
use App\Models\SubCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

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
        $data = $request->except(['sub_categories']);
        $data['is_new'] = $data['is_new'] ==  true ? 1 : 0;
        $data['is_featured'] = $data['is_featured'] == true ? 1 : 0;
        $data['coming_soon'] = $data['coming_soon'] == true ? 1 : 0;
        if ($request->hasFile('image')) {
            $data['image'] = Storage::disk('public')->put('/', $request->file('image'));
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
        $product = ProductHead::create($data);
        $product->sub_categories()->attach($request->sub_categories);
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

        $data = $request->except(['sub_categories']);
        $data['is_new'] = $request->is_new ? 1 : 0;
        $data['is_featured'] = $request->is_featured ? 1 : 0;
        $data['coming_soon'] = $request->coming_soon ? 1 : 0;

        if ($request->hasFile('image')) {
            if (!is_null($product->image)) {
                Storage::delete($product->image);
            }
            $data['image'] = Storage::disk('public')->put('/', $request->file('image'));
        }
        if ($request->hasFile('image1')) {
            if (!is_null($product->image1)) {
                Storage::delete($product->image1);
            }
            $data['image1'] = Storage::disk('public')->put('/', $request->file('image1'));
        }
        if ($request->hasFile('image2')) {
            if (!is_null($product->image2)) {
                Storage::delete($product->image2);
            }
            $data['image2'] = Storage::disk('public')->put('/', $request->file('image2'));
        }
        if ($request->hasFile('image3')) {
            if (!is_null($product->image3)) {
                Storage::delete($product->image3);
            }
            $data['image3'] = Storage::disk('public')->put('/', $request->file('image3'));
        }
        if ($request->hasFile('image4')) {
            if (!is_null($product->image4)) {
                Storage::delete($product->image4);
            }
            $data['image4'] = Storage::disk('public')->put('/', $request->file('image4'));
        }
        if ($request->hasFile('image5')) {
            if (!is_null($product->image5)) {
                Storage::delete($product->image5);
            }
            $data['image5'] = Storage::disk('public')->put('/', $request->file('image5'));
        }

        if ($product) {
            $product->update($data);
            $product->sub_categories()->sync($request->sub_categories);
            return response()->json(['message' => 'Product Updated Successfully'], 200);
        } else {
            return response()->json(['message' =>  'Product Not Updated'], 201);
        }
    }

    public function destroy(int $id)
    {
        $product = ProductHead::find($id);
        if ($product) {
            $is_sub_category_attached = ProductHeadSubCategory::where('product_head_id', $id)->first();
            if ($is_sub_category_attached)
                return  response()->json(['message' => 'Product attached with sub category, can not delete.'], 201);

            if (!is_null($product->image)) {
                Storage::delete($product->image);
            }
            if (!is_null($product->image1)) {
                Storage::delete($product->image1);
            }
            if (!is_null($product->image2)) {
                Storage::delete($product->image2);
            }
            if (!is_null($product->image3)) {
                Storage::delete($product->image3);
            }
            if (!is_null($product->image4)) {
                Storage::delete($product->image4);
            }
            if (!is_null($product->image5)) {
                Storage::delete($product->image5);
            }
            //Deleting related product colors
            $productColors = ProductColor::where('product_head_id', $id)->get();
            if (count($productColors)) {
                foreach ($productColors  as $key => $product_color) {
                    if (!is_null($product_color->color_image)) {
                        Storage::delete($product_color->color_image);
                    }
                    if (!is_null($product_color->image1)) {
                        Storage::delete($product_color->image1);
                    }
                    if (!is_null($product_color->image2)) {
                        Storage::delete($product_color->image2);
                    }
                    if (!is_null($product_color->image3)) {
                        Storage::delete($product_color->image3);
                    }
                    if (!is_null($product_color->image4)) {
                        Storage::delete($product_color->image4);
                    }
                    if (!is_null($product_color->image5)) {
                        Storage::delete($product_color->image5);
                    }
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
