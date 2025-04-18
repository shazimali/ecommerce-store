<?php

namespace App\Http\Controllers\API\Admin\ProductReviews;

use App\Http\Controllers\Controller;
use App\Http\Requests\API\Admin\ProductReviews\StoreProductReviewRequest;
use App\Http\Requests\API\Admin\ProductReviews\UpdateProductReviewRequest;
use App\Services\API\Admin\ProductReviews\ProductReviewService;
use Illuminate\Http\Request;

class ProductReviewController extends Controller
{
    public $productReviewService;

    public function __construct(ProductReviewService $productReviewService)
    {
        $this->productReviewService = $productReviewService;
    }

    public function index(Request $request)
    {
        return $this->productReviewService->getAll($request);
    }

    public function getAllProducts()
    {
        return $this->productReviewService->getAllProducts();
    }

    public function store(StoreProductReviewRequest $request)
    {
        return $this->productReviewService->store($request);
    }

    public function edit(int $id)
    {
        return $this->productReviewService->edit($id);
    }

    public function update(UpdateProductReviewRequest $request, int $id)
    {
        return $this->productReviewService->update($request, $id);
    }

    public function  destroy(int $id)
    {
        return $this->productReviewService->destroy($id);
    }
}
