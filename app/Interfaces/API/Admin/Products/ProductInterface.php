<?php

namespace App\Interfaces\API\Admin\Products;

use App\Http\Requests\API\Admin\Products\StoreProductPriceRequest;
use App\Http\Requests\API\Admin\Products\StoreProductRequest;
use App\Http\Requests\API\Admin\Products\UpdateProductPriceRequest;
use App\Http\Requests\API\Admin\Products\UpdateProductRequest;
use Illuminate\Http\Request;

interface ProductInterface
{
    public function getAll(Request $request);
    public function store(StoreProductRequest $request);
    public function edit(int $id);
    public function update(UpdateProductRequest $request, int $id);
    public function destroy(int $id);
    public function getAllSubCategories();
}
