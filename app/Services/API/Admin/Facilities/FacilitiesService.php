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
use App\Models\FacilityCountry;
use Illuminate\Http\Request;

class FacilitiesService implements FacilitiesInterface
{
    public function getAll(Request $request)
    {
        $facility  = Facility::paginate($request->item_per_page);
        if ($request->search) {
            $facility  = Facility::where('name', 'like', "%{$request->search}%")
                ->orWhere('id', 'like', "%{$request->search}%")
                ->paginate($request->item_per_page);
        }
        if ($facility) {
            return FacilitiesListResource::collection($facility);
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
        try {
            $facility = Facility::create($data);
            $facility->countries()->attach($data['countries']);
            return response()->json(['message' => 'Facilities Stored Successfully'], 200);
        } catch (\Throwable $th) {
            return response()->json($th->getMessage(), 201);
        }
    }

    public function edit(int $id)
    {
        $facility  = Facility::find($id);
        if ($facility) {
            return new FacilitiesEditResource($facility);
        } else {
            return response()->json(['message' => 'Facilities not exists'], 201);
        }
    }

    public function update(UpdateFacilitiesRequest $request, int $id)
    {
        $facility  = Facility::find($id);
        if ($facility) {
            $data = [
                'title' => $request->title,
                'class' => $request->class,
            ];
            $facility->update($data);
            return response()->json(['message' => 'Facilities updated successfully.'], 200);
        } else {
            return response()->json(['message' => 'Facilities not found.'], 201);
        }
    }

    public function destroy(int $id)
    {
        $facility  = Facility::find($id);
        if ($facility) {
            $facility->countries()->detach();
            // $is_facility_attached_with_country = FacilityCountry::where('country_id', $id)->first();
            // if ($is_facility_attached_with_country)
            //     return  response()->json(['message' => 'Facility attached with country, can not delete.'], 201);

            $facility->delete();
            return response()->json(['message' => 'Facilities Deleted Successfully'], 200);
        } else {
            return response()->json(['message' => 'Facilities not found.'], 201);
        }
    }
}
