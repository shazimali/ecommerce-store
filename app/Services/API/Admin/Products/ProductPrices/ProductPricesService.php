<?php

namespace App\Services\API\Admin\Products\ProductPrices;

use App\Http\Requests\API\Admin\Products\ProductPrices\StoreProductPriceRequest;
use App\Http\Requests\API\Admin\Products\ProductPrices\UpdateProductPriceRequest;
use App\Http\Resources\API\Admin\Countries\CountryListResource;
use App\Http\Resources\API\Admin\Products\ProductPrices\ProductPricesEditResource;
use App\Http\Resources\API\Admin\Products\ProductPrices\ProductPricesListResource;
use App\Interfaces\API\Admin\Products\ProductPrices\ProductPricesInterface;
use App\Models\Country;
use App\Models\ProductHeadPrice;

class ProductPricesService implements ProductPricesInterface
{
    public function getPricesByProductID(int $id)
    {
        return response()->json([
            'prices' =>ProductPricesListResource ::collection(ProductHeadPrice::where('product_head_id', $id)->with('product_head', 'country')->get()),
            'countries' => CountryListResource::collection(Country::all())
        ]);
    }

    public function store(StoreProductPriceRequest $request)
    {
        ProductHeadPrice::create($request->all());
        return response()->json(['message' => 'Product price saved successfully.'], 200);
    }

    public function edit(int $id)
    {
        $price = ProductHeadPrice::find($id);
        if ($price) {
            return new ProductPricesEditResource($price);
        } else {
            return response()->json(['message' => 'Product price notfound.'], 201);
        }
    }

    public function update(UpdateProductPriceRequest $request, int $id)
    {
        $price = ProductHeadPrice::whereId($id)->first();
        if ($price) {
            $price->update($request->all());
        }
        return response()->json(['message' => 'Product price updated successfully.'], 200);
    }

    public function destroy(int $id)
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
