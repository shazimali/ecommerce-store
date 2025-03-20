<?php

namespace App\Http\Controllers\API\Admin\Products\ProductPrices;

use App\Http\Controllers\Controller;
use App\Http\Requests\API\Admin\Products\ProductPrices\StoreProductPriceRequest;
use App\Http\Requests\API\Admin\Products\ProductPrices\UpdateProductPriceRequest;
use App\Services\API\Admin\Products\ProductPrices\ProductPricesService;
use Illuminate\Http\Request;

class ProductPricesController extends Controller
{
    public $productPriceService;

    public  function __construct(ProductPricesService $productPriceService)
    {
        $this->productPriceService=$productPriceService;
    }

    public function getPrices(int $id)
    {
        return $this->productPriceService->getPricesByProductID($id);
    }

    public function store(StoreProductPriceRequest $request)
    {
        return $this->productPriceService->store($request);

    }

    public function edit(int $id)
    {
        return $this->productPriceService->edit($id);
    }

    public function update(UpdateProductPriceRequest $request, int $id)
    {
      return $this->productPriceService->update($request, $id);
    }

    public function destroy(int $id)
    {
        return $this->productPriceService->destroy($id);
    }

}
