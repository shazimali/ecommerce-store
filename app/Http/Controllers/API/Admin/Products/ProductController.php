<?php

namespace App\Http\Controllers\API\Admin\Products;

use App\Http\Controllers\Controller;
use App\Http\Requests\API\Admin\Products\StoreProductPriceRequest;
use App\Http\Requests\API\Admin\Products\StoreProductRequest;
use App\Http\Requests\API\Admin\Products\UpdateProductPriceRequest;
use App\Http\Requests\API\Admin\Products\UpdateProductRequest;
use App\Services\API\Admin\Products\ProductService;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public $productService;

    public function __construct(ProductService $productService)
    {
        $this->productService = $productService;
    }

    public function index(Request $request)
    {
        $this->authorize('product_access');
        return $this->productService->getAll($request);
    }

    public function store(StoreProductRequest $request)
    {
        $this->authorize('product_create');
        return $this->productService->store($request);
    }

    public function edit(int $id)
    {
        $this->authorize('product_edit');
        return $this->productService->edit($id);
    }

    public function update(UpdateProductRequest $request, int $id)
    {
        $this->authorize('product_edit');
        return $this->productService->update($request, $id);
    }

    public function destroy(int $id)
    {
        $this->authorize('product_delete');
        return $this->productService->destroy($id);
    }

    public function getAllSubCategories()
    {
        return $this->productService->getAllSubCategories();
    }

    public function getPrices(int $id)
    {
        $this->authorize('product_price_access');
        return $this->productService->getPricesByProductID($id); // return all prices
    }

    public function storePrice(StoreProductPriceRequest $request)
    {
        $this->authorize('product_price_create');
        return $this->productService->storePrice($request);
    }

    public function editPrice(int $id)
    {
        $this->authorize('product_price_update');
        return $this->productService->editPrice($id);
    }

    public function updatePrice(UpdateProductPriceRequest $request, int $id)
    {
        $this->authorize('product_price_update');
        return $this->productService->updatePrice($request, $id);
    }

    public function deletePrice(int $id)
    {
        $this->authorize('product_price_delete');
        return $this->productService->deletePrice($id);
    }
}
