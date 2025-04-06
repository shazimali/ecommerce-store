<?php

namespace App\Services\API\Admin\Coupons;

use App\Http\Requests\API\Admin\Coupons\StoreCouponRequest;
use App\Http\Requests\API\Admin\Coupons\UpdateCouponRequest;
use App\Http\Resources\API\Admin\Countries\CountryListResource;
use App\Http\Resources\API\Admin\Coupons\CouponEditResource;
use App\Http\Resources\API\Admin\Coupons\CouponListResource;
use App\Interfaces\API\Admin\Coupons\CouponsInterface;
use App\Models\Country;
use App\Models\Coupon;
use Illuminate\Http\Request;

class CouponsService implements CouponsInterface
{
    public function getAll(Request $request)
    {
        $perPage = $request->itemPerPage;
        $coupon = Coupon::with('country')->paginate($perPage);
        if ($coupon) {
            return CouponListResource::collection($coupon);
        } else {
            return response()->json(['message' => 'Coupon Not found'], 200);
        }
    }
    public function getAllCountries()
    {
        $countries = Country::all();
        if ($countries) {
            return CountryListResource::collection($countries);
        }
        return response()->json(['message' => 'No country found'], 201);
    }

    public function store(StoreCouponRequest $request)
    {
        $coupon = Coupon::create($request->all());
        if ($coupon) {
            return response()->json(['message' => 'Coupon Stored Successfully.'], 200);
        } else {
            return response()->json(['message' => 'Coupon Not Stored '], 201);
        }
    }

    public function edit(int $id)
    {
        $coupon = Coupon::find($id);
        if ($coupon) {
            return new CouponEditResource($coupon);
        } else {
            return response()->json(['message' => 'Coupon not exist'], 201);
        }
    }
    public function update(UpdateCouponRequest $request, int $id)
    {
        $coupon = Coupon::find($id);
        if ($coupon) {
            $data = [
                'title' => $request->title,
                'code' => $request->code,
                'discount' => $request->discount,
                'date_from' => $request->date_from,
                'date_to' => $request->date_to,
                'country_id' => $request->country_id,
            ];
            $coupon->update($data);
            return response()->json(['message' => 'Coupon updated successfully.'], 200);
        } else {
            return response()->json(['message' => 'Coupon not found.'], 201);
        }
    }
    public function destroy(int $id)
    {
        $coupon = Coupon::find($id);
        if ($coupon) {
            $coupon->delete();
            return response()->json(['message' => 'Coupon deleted successfully.'], 200);
        } else {
            return response()->json(['message' => 'Coupon not found.'], 201);
        }
    }
}
