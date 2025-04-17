<?php

namespace App\Interfaces\API\Admin\ProductReviews;

use App\Http\Requests\API\Admin\ProductReviews\StoreProductReviewRequest;
use App\Http\Requests\API\Admin\ProductReviews\UpdateProductReviewRequest;
use Illuminate\Http\Request;

interface ProductReviewInterface
{
    public function getAll(Request $request);
    public function getAllProducts();
    public function store(StoreProductReviewRequest $request);
    public function edit(int $id);
    public function update(UpdateProductReviewRequest $request, int $id);
    public function destroy(int $id);
}
