<?php

namespace App\Services\API\Admin\Bundles;

use App\Interfaces\API\Admin\Bundles\BundlePriceInterface;
use App\Models\Country;
use App\Models\BundlePrice;
use App\Http\Resources\API\Admin\Countries\CountryListResource;
use App\Http\Resources\API\Admin\Bundles\BundlePricesEditResource;
use App\Http\Resources\API\Admin\Bundles\BundlePricesListResource;

class BundlePriceService implements BundlePriceInterface
{
    public function getPricesByBundleID(int $id)
    {
        return response()->json([
            'prices' => BundlePricesListResource::collection(BundlePrice::where('bundle_id', $id)->with('bundle', 'country')->get()),
            'countries' => CountryListResource::collection(Country::all())
        ]);
    }

    public function storePrice(array $data)
    {
        BundlePrice::create($data);
        return response()->json(['message' => 'Bundle price saved successfully.'], 200);
    }

    public function editPrice(int $id)
    {
        $price = BundlePrice::find($id);
        if ($price) {
            return new BundlePricesEditResource($price);
        } else {
            return response()->json(['message' => 'Bundle price notfound.'], 201);
        }
    }

    public function updatePrice(int $id, array $data)
    {
        $price = BundlePrice::whereId($id)->first();
        if ($price) {
            $price->update($data);
        }
        return response()->json(['message' => 'Bundle price updated successfully.'], 200);
    }

    public function deletePrice(int $id)
    {
        $price = BundlePrice::whereId($id)->first();
        if ($price) {
            $price->delete();
            return response()->json(['message' => 'Bundle price deleted successfully.'], 200);
        } else {
            return response()->json(['message' => 'Bundle price can not delete.'], 201);
        }
    }
}
