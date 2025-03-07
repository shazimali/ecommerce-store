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
        return $this->productColorsService->getAll($id);
    }

    public function store(StoreProductColorsRequest $request)
    {
        return $this->productColorsService->store($request);
    }

    public function edit(int $id)
    {
        return $this->productColorsService->edit($id);
    }

    public function update(UpdateProductColorsRequest $request, int $id)
    {
        return $this->productColorsService->update($request, $id);
    }

    public function destroy(int $id)
    {
        return $this->productColorsService->destroy($id);
    }
}
