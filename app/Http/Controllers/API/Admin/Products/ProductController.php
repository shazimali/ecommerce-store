<?php

namespace App\Http\Controllers\API\Admin\Products;

use App\Http\Controllers\Controller;
use App\Http\Requests\API\Admin\Products\StoreProductRequest;
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
}
