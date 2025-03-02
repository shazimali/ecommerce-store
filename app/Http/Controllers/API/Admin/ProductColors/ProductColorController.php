<?php

namespace App\Http\Controllers\API\Admin\ProductColors;

use App\Http\Controllers\Controller;
use App\Http\Requests\API\Admin\ProductColors\StoreProductColorRequest;
use App\Http\Requests\API\Admin\ProductColors\UpdateProductColorRequest;
use App\Services\API\Admin\ProductColors\ProductColorsService;
use Illuminate\Http\Request;

class ProductColorController extends Controller
{
    public $productColorService;

    public function __construct(ProductColorsService $productColorService)
    {
        $this->productColorService = $productColorService;
    }

    public function index(Request $request)
    {
        return $this->productColorService->getAll($request);
    }

    public function store(StoreProductColorRequest $request)
    {
        return $this->productColorService->store($request);
    }

    public function edit(int $id)
    {
        return $this->productColorService->edit($id);
    }

    public function update(UpdateProductColorRequest $request, int $id)
    {
        return $this->productColorService->update($request, $id);
    }

    public function destroy(int $id)
    {
        return $this->productColorService->destroy($id);
    }
}
