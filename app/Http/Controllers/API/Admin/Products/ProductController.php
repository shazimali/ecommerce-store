<?php

namespace App\Http\Controllers\API\Admin\Products;

use App\Http\Controllers\Controller;
use App\Http\Requests\API\Admin\Products\StoreProductPriceRequest;
use App\Http\Requests\API\Admin\Products\StoreProductRequest;
use App\Http\Requests\API\Admin\Products\UpdateProductPriceRequest;
use App\Http\Requests\API\Admin\Products\UpdateProductRequest;
use App\Interfaces\API\Admin\Products\ProductInterface;
use App\Interfaces\API\Admin\Products\ProductPriceInterface;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public $productService;
    public $productPriceService;

    public function __construct(
        ProductInterface $productService,
        ProductPriceInterface $productPriceService
    ) {
        $this->productService = $productService;
        $this->productPriceService = $productPriceService;
    }

    public function index(Request $request)
    {
        $this->authorize('product_access');
        $itemsPerPage = $request->get('items_per_page', 10);
        return $this->productService->getAll($request->all(), $itemsPerPage);
    }

    public function store(StoreProductRequest $request)
    {
        $this->authorize('product_create');
        return $this->productService->store($request->all());
    }

    public function edit(int $id)
    {
        $this->authorize('product_edit');
        return $this->productService->edit($id);
    }

    public function update(UpdateProductRequest $request, int $id)
    {
        $this->authorize('product_edit');
        return $this->productService->update($id, $request->all());
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
        return $this->productPriceService->getPricesByProductID($id);
    }

    public function storePrice(StoreProductPriceRequest $request)
    {
        $this->authorize('product_price_create');
        return $this->productPriceService->storePrice($request->all());
    }

    public function editPrice(int $id)
    {
        $this->authorize('product_price_update');
        return $this->productPriceService->editPrice($id);
    }

    public function updatePrice(UpdateProductPriceRequest $request, int $id)
    {
        $this->authorize('product_price_update');
        return $this->productPriceService->updatePrice($id, $request->all());
    }

    public function deletePrice(int $id)
    {
        $this->authorize('product_price_delete');
        return $this->productPriceService->deletePrice($id);
    }
}
