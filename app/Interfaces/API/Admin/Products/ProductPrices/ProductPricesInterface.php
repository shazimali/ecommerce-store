<?php

namespace App\Interfaces\API\Admin\Products\ProductPrices;

use App\Http\Requests\API\Admin\Products\ProductPrices\StoreProductPriceRequest;
use App\Http\Requests\API\Admin\Products\ProductPrices\UpdateProductPriceRequest;

interface ProductPricesInterface
{
    public function getPricesByProductID(int $id);
    public function store(StoreProductPriceRequest $request);
    public function edit(int $id);
    public function update(UpdateProductPriceRequest $request, int $id);
    public function destroy(int $id);
}
