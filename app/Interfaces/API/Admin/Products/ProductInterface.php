<?php

namespace App\Interfaces\API\Admin\Products;

use App\Http\Requests\API\Admin\Products\StoreProductPriceRequest;
use App\Http\Requests\API\Admin\Products\StoreProductRequest;
use App\Http\Requests\API\Admin\Products\UpdateProductPriceRequest;
use App\Http\Requests\API\Admin\Products\UpdateProductRequest;
use Illuminate\Http\Request;

interface ProductInterface
{
    public function getAll(array $filters, int $perPage);
    public function store(array $data);
    public function edit(int $id);
    public function update(int $id, array $data);
    public function destroy(int $id);
    public function getAllSubCategories();
}
