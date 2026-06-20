<?php

namespace App\Http\Controllers\API\Admin\Bundles\BundleColors;

use App\Http\Controllers\Controller;
use App\Http\Requests\API\Admin\Bundles\BundleColors\StoreBundleColorsRequest;
use App\Http\Requests\API\Admin\Bundles\BundleColors\UpdateBundleColorsRequest;
use App\Services\API\Admin\Bundles\BundleColors\BundleColorsService;
use Illuminate\Http\Request;

class BundleColorsController extends Controller
{
    public $bundleColorsService;

    public function __construct(BundleColorsService $bundleColorsService)
    {
        $this->bundleColorsService = $bundleColorsService;
    }

    public function index(int $id)
    {
        $this->authorize('bundle_color_access');
        return $this->bundleColorsService->getAll($id);
    }

    public function store(StoreBundleColorsRequest $request)
    {
        $this->authorize('bundle_color_create');
        return $this->bundleColorsService->store($request);
    }

    public function edit(int $id)
    {
        $this->authorize('bundle_color_update');
        return $this->bundleColorsService->edit($id);
    }

    public function update(UpdateBundleColorsRequest $request, int $id)
    {
        $this->authorize('bundle_color_update');
        return $this->bundleColorsService->update($request, $id);
    }

    public function destroy(int $id)
    {
        $this->authorize('bundle_color_delete');
        return $this->bundleColorsService->destroy($id);
    }
}
