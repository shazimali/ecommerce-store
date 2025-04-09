<?php

namespace App\Http\Controllers\API\Admin\Products\ProductColors;

use App\Http\Controllers\Controller;
use App\Http\Requests\API\Admin\Products\ProductColors\StoreProductColorsRequest;
use App\Http\Requests\API\Admin\Products\ProductColors\UpdateProductColorsRequest;
use App\Services\API\Admin\Products\ProductColors\ProductColorsService;
use Illuminate\Http\Request;

class ProductColorsController extends Controller
{
    public $productColorsService;

    public function __construct(ProductColorsService $productColorsService)
    {
        $this->productColorsService = $productColorsService;
    }

    public function index(int $id)
    {
        $this->authorize('product_color_access');
        return $this->productColorsService->getAll($id);
    }

    public function store(StoreProductColorsRequest $request)
    {
        $this->authorize('product_color_create');
        return $this->productColorsService->store($request);
    }

    public function edit(int $id)
    {
        $this->authorize('product_color_update');
        return $this->productColorsService->edit($id);
    }

    public function update(UpdateProductColorsRequest $request, int $id)
    {
        $this->authorize('product_color_update');
        return $this->productColorsService->update($request, $id);
    }

    public function destroy(int $id)
    {
        $this->authorize('product_color_delete');
        return $this->productColorsService->destroy($id);
    }
}
