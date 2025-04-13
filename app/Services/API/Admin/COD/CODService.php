<?php

namespace App\Services\API\Admin\COD;

use App\Http\Requests\API\Admin\COD\StoreCODRequest;
use App\Http\Requests\API\Admin\COD\UpdateCODRequest;
use App\Http\Resources\API\Admin\COD\CODEditResource;
use App\Http\Resources\API\Admin\COD\CODListResource;
use App\Http\Resources\API\Admin\Countries\CountryListResource;
use App\Interfaces\API\Admin\COD\CODInterface;
use App\Models\CashOnDelivery;
use App\Models\Country;
use Illuminate\Http\Request;

class CODService implements CODInterface
{
    public function getAll(Request $request)
    {

        $cashOnDelivery  = CashOnDelivery::paginate($request->item_per_page);
        if ($request->search) {
            $cashOnDelivery->where('name', 'like', "%{$request->search}%")
                ->orWhere('id', 'like', "%{$request->search}%");
        }
        if ($cashOnDelivery) {
            return CODListResource::collection($cashOnDelivery);
        }
        return response()->json(['message' => 'COD Not Found'], 201);
    }

    public function getAllCountries()
    {
        $countries = Country::all();
        if ($countries) {
            return CountryListResource::collection($countries);
        }
        return response()->json(['message' => 'No country found'], 201);
    }

    public function store(StoreCODRequest $request)
    {
        $data = $request->all();
        if ($data) {
            $cashOnDelivery = CashOnDelivery::create($data);
            $cashOnDelivery->countries()->attach($data['countries']);
            return response()->json(['message' => 'COD Stored Successfully'], 200);
        } else {
            return response()->json(['message' => 'COD Not Found'], 201);
        }
    }

    public function edit(int $id)
    {
        $cashOnDelivery  = CashOnDelivery::find($id);
        if ($cashOnDelivery) {
            return new CODEditResource($cashOnDelivery);
        } else {
            return response()->json(['message' => 'COD Not Found'], 201);
        }
    }

    public function update(UpdateCODRequest $request, int $id)
    {
        $cashOnDelivery  = CashOnDelivery::find($id);
        if ($cashOnDelivery) {
            $data = [
                'title' => $request->title,
                'api_test_url' => $request->api_test_url,
                'api_url' => $request->api_url,
                'api_key' => $request->api_key,
                'api_password' => $request->api_password,
                'status' => $request->status,
            ];
            $cashOnDelivery->update($data);
            $cashOnDelivery->countries()->sync($request->countries);
            return response()->json(['message' => 'COD updated successfully.'], 200);
        } else {
            return response()->json(['message' => 'COD Not Found'], 201);
        }
    }

    public function destroy(int $id)
    {
        $cashOnDelivery  = CashOnDelivery::find($id);
        if ($cashOnDelivery) {
            $cashOnDelivery->countries()->detach();
            $cashOnDelivery->delete();
            return response()->json(['message' => 'COD Deleted Successfully'], 200);
        } else {
            return response()->json(['message' => 'COD not found.'], 201);
        }
    }
}
