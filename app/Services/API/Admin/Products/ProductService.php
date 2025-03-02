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
use App\Models\ProductHead;
use App\Models\ProductHeadPrice;
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
        $data['is_new'] = $data['is_new'] ==  true ? 1 : 0;
        $data['is_featured'] = $data['is_featured'] == true ? 1 : 0;
        $data['coming_soon'] = $data['coming_soon'] == true ? 1 : 0;
        if ($request->hasFile('image')) {
            if (Storage::exists($product->image)) {
                Storage::delete($product->image);
            }
            $data['image'] = Storage::disk('public')->put('/', $request->file('image'));
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
            if (Storage::exists($product->image)) {
                Storage::delete($product->image);
            }
            $product->delete();
            return response()->json(['message' => 'Product Deleted Successfully'], 200);
        } else {
            return response()->json(['message' => 'Product not found'], 201);
        }
    }

    public function getAllSubCategories()
    {
        return SubCategoryListResource::collection(SubCategory::all());
    }

    public function getPricesByProductID(int $id)
    {
        return response()->json([
            'prices' => ProductPricesListResource::collection(ProductHeadPrice::where('product_head_id', $id)->with('product_head', 'country')->get()),
            'countries' => CountryListResource::collection(Country::all())
        ]);
    }

    public function storePrice(StoreProductPriceRequest $request)
    {
        ProductHeadPrice::create($request->all());
        return response()->json(['message' => 'Product price saved successfully.'], 200);
    }

    public function editPrice(int $id)
    {
        $price = ProductHeadPrice::find($id);
        if ($price) {
            return new ProductPricesEditResource($price);
        } else {
            return response()->json(['message' => 'Product price notfound.'], 201);
        }
    }

    public function updatePrice(UpdateProductPriceRequest $request, int $id)
    {
        $price = ProductHeadPrice::whereId($id)->first();
        if ($price) {
            $price->update($request->all());
        }
        return response()->json(['message' => 'Product price updated successfully.'], 200);
    }

    public function deletePrice(int $id)
    {
        $price = ProductHeadPrice::whereId($id)->first();
        if ($price) {
            $price->delete();
            return response()->json(['message' => 'Product price deleted successfully.'], 200);
        } else {
            return response()->json(['message' => 'Product price can not delete.'], 201);
        }
    }
}
