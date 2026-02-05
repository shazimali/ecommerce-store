<?php

namespace App\Services\API\Admin\Products;

use App\Interfaces\API\Admin\Products\ProductPriceInterface;
use App\Models\Country;
use App\Models\ProductHeadPrice;
use App\Http\Resources\API\Admin\Countries\CountryListResource;
use App\Http\Resources\API\Admin\Products\ProductPricesEditResource;
use App\Http\Resources\API\Admin\Products\ProductPricesListResource;

class ProductPriceService implements ProductPriceInterface
{
    public function getPricesByProductID(int $id)
    {
        return response()->json([
            'prices' => ProductPricesListResource::collection(ProductHeadPrice::where('product_head_id', $id)->with('product_head', 'country')->get()),
            'countries' => CountryListResource::collection(Country::all())
        ]);
    }

    public function storePrice(array $data)
    {
        ProductHeadPrice::create($data);
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

    public function updatePrice(int $id, array $data)
    {
        $price = ProductHeadPrice::whereId($id)->first();
        if ($price) {
            $price->update($data);
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
