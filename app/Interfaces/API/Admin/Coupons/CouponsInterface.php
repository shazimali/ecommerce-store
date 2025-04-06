<?php

namespace App\Interfaces\API\Admin\Coupons;

use App\Http\Requests\API\Admin\Coupons\StoreCouponRequest;
use App\Http\Requests\API\Admin\Coupons\UpdateCouponRequest;
use Illuminate\Http\Request;

interface CouponsInterface
{
    public function getAll(Request $request);
    public function getAllCountries();
    public function store(StoreCouponRequest $request);
    public function edit(int $id);
    public function update(UpdateCouponRequest $request, int $id);
    public function destroy(int $id);
}
