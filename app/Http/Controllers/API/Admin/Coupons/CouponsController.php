<?php

namespace App\Http\Controllers\API\Admin\Coupons;

use App\Http\Controllers\Controller;
use App\Http\Requests\API\Admin\Coupons\StoreCouponRequest;
use App\Http\Requests\API\Admin\Coupons\UpdateCouponRequest;
use App\Services\API\Admin\Coupons\CouponsService;
use Illuminate\Http\Request;

class CouponsController extends Controller
{
    public $couponsService;

    public function __construct(CouponsService $couponsService)
    {
        $this->couponsService = $couponsService;
    }

    public function index(Request $request)
    {
        $this->authorize('coupon_access');
        return $this->couponsService->getAll($request);
    }

    public function getAllCountries()
    {
        return $this->couponsService->getAllCountries();
    }

    public function store(StoreCouponRequest $request)
    {
        $this->authorize('coupon_create');
        return $this->couponsService->store($request);
    }

    public function edit(int $id)
    {
        $this->authorize('coupon_edit');
        return $this->couponsService->edit($id);
    }

    public function update(UpdateCouponRequest $request, int $id)
    {
        $this->authorize('coupon_edit');
        return $this->couponsService->update($request, $id);
    }

    public function destroy(int $id)
    {
        $this->authorize('coupon_delete');
        return $this->couponsService->destroy($id);
    }
}
