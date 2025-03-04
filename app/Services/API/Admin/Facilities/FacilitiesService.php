<?php

namespace App\Services\API\Admin\Facilities;

use App\Http\Requests\API\Admin\Facilities\StoreFacilitiesRequest;
use App\Http\Requests\API\Admin\Facilities\UpdateFacilitiesRequest;
use App\Http\Resources\API\Admin\Countries\CountryListResource;
use App\Http\Resources\API\Admin\Facilities\FacilitiesEditResource;
use App\Http\Resources\API\Admin\Facilities\FacilitiesListResource;
use App\Interfaces\API\Admin\Facilities\FacilitiesInterface;
use App\Models\Country;
use App\Models\Facility;
use Illuminate\Http\Request;

class FacilitiesService implements FacilitiesInterface
{
    public function getAll(Request $request)
    {
        $facilities = Facility::paginate($request->item_per_page);
        if ($request->search) {
            $facilities = Facility::where('name', 'like', "%{$request->search}%")
                ->orWhere('id', 'like', "%{$request->search}%")
                ->paginate($request->item_per_page);
        }
        if ($facilities) {
            return FacilitiesListResource::collection($facilities);
        }
        return response()->json(['message' => 'No permissions found'], 200);
    }

    public function getAllCountries()
    {
        $countries = Country::all();
        if ($countries) {
            return CountryListResource::collection($countries);
        }
        return response()->json(['message' => 'No country found'], 201);
    }

    public function store(StoreFacilitiesRequest $request)
    {
        $data = $request->all();
        $facilities = Facility::create($data);
        if ($facilities) {
            return response()->json(['message' => 'Facilities Stored Successfully'], 200);
        } else {
            return response()->json(['message' => 'Facilities Not Stored'], 201);
        }
    }

    public function edit(int $id)
    {
        $facilities = Facility::find($id);
        if ($facilities) {
            return new FacilitiesEditResource($facilities);
        } else {
            return response()->json(['message' => 'Facilities not exists'], 201);
        }
    }

    public function update(UpdateFacilitiesRequest $request, int $id)
    {
        $facilities = Facility::find($id);
        if ($facilities) {
            $data = [
                'title' => $request->title,
                'class' => $request->class,
            ];
            $facilities->update($data);
            return response()->json(['message' => 'Facilities updated successfully.'], 200);
        } else {
            return response()->json(['message' => 'Facilities not found.'], 201);
        }
    }

    public function destroy(int $id)
    {
        $facilities = Facility::find($id);
        if ($facilities) {
            $facilities->delete();
            return response()->json(['message' => 'Facilities Deleted Successfully'], 200);
        } else {
            return response()->json(['message' => 'Facilities not found.'], 201);
        }
    }
}
