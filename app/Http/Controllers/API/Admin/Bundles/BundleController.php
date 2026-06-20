<?php

namespace App\Http\Controllers\API\Admin\Bundles;

use App\Http\Controllers\Controller;
use App\Http\Requests\API\Admin\Bundles\StoreBundlePriceRequest;
use App\Http\Requests\API\Admin\Bundles\StoreBundleRequest;
use App\Http\Requests\API\Admin\Bundles\UpdateBundlePriceRequest;
use App\Http\Requests\API\Admin\Bundles\UpdateBundleRequest;
use App\Interfaces\API\Admin\Bundles\BundleInterface;
use App\Interfaces\API\Admin\Bundles\BundlePriceInterface;
use Illuminate\Http\Request;

class BundleController extends Controller
{
    public $bundleService;
    public $bundlePriceService;

    public function __construct(
        BundleInterface $bundleService,
        BundlePriceInterface $bundlePriceService
    ) {
        $this->bundleService = $bundleService;
        $this->bundlePriceService = $bundlePriceService;
    }

    public function index(Request $request)
    {
        $this->authorize('bundle_access');
        $itemsPerPage = $request->get('items_per_page', 10);
        return $this->bundleService->getAll($request->all(), $itemsPerPage);
    }

    public function store(StoreBundleRequest $request)
    {
        $this->authorize('bundle_create');
        return $this->bundleService->store($request->all());
    }

    public function edit(int $id)
    {
        $this->authorize('bundle_edit');
        return $this->bundleService->edit($id);
    }

    public function update(UpdateBundleRequest $request, int $id)
    {
        $this->authorize('bundle_edit');
        return $this->bundleService->update($id, $request->all());
    }

    public function destroy(int $id)
    {
        $this->authorize('bundle_delete');
        return $this->bundleService->destroy($id);
    }

    public function getPrices(int $id)
    {
        $this->authorize('bundle_price_access');
        return $this->bundlePriceService->getPricesByBundleID($id);
    }

    public function storePrice(StoreBundlePriceRequest $request)
    {
        $this->authorize('bundle_price_create');
        return $this->bundlePriceService->storePrice($request->all());
    }

    public function editPrice(int $id)
    {
        $this->authorize('bundle_price_update');
        return $this->bundlePriceService->editPrice($id);
    }

    public function updatePrice(UpdateBundlePriceRequest $request, int $id)
    {
        $this->authorize('bundle_price_update');
        return $this->bundlePriceService->updatePrice($id, $request->all());
    }

    public function deletePrice(int $id)
    {
        $this->authorize('bundle_price_delete');
        return $this->bundlePriceService->deletePrice($id);
    }
}
