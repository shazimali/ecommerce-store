<?php

namespace App\Interfaces\API\Admin\Bundles\BundleColors;

use App\Http\Requests\API\Admin\Bundles\BundleColors\StoreBundleColorsRequest;
use App\Http\Requests\API\Admin\Bundles\BundleColors\UpdateBundleColorsRequest;

interface BundleColorsInterface
{
    public function getAll(int $id);
    public function store(StoreBundleColorsRequest $request);
    public function edit(int $id);
    public function update(UpdateBundleColorsRequest $request, int $id);
    public function destroy(int $id);
}
