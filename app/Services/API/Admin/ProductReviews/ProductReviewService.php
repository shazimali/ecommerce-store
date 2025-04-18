<?php

namespace App\Services\API\Admin\ProductReviews;

use App\Http\Requests\API\Admin\ProductReviews\StoreProductReviewRequest;
use App\Http\Requests\API\Admin\ProductReviews\UpdateProductReviewRequest;
use App\Http\Resources\API\Admin\ProductReviews\ProductReviewEditResource;
use App\Http\Resources\API\Admin\ProductReviews\ProductReviewListResource;
use App\Http\Resources\API\Admin\ProductReviews\ProductReviewResource;
use App\Http\Resources\API\Admin\Products\ProductListResource;
use App\Interfaces\API\Admin\ProductReviews\ProductReviewInterface;
use App\Models\ProductHead;
use App\Models\ProductReview;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ProductReviewService implements ProductReviewInterface
{
    public function getAll(Request $request)
    {
        $productReview  = ProductReview::paginate($request->item_per_page);
        if ($productReview) {
            return ProductReviewListResource::collection($productReview);
        }
        return response()->json(['message' => 'Product Review not found'], 201);
    }

    public function getAllProducts()
    {
        $product = ProductHead::all();
        if ($product) {
            return ProductReviewResource::collection($product);
        }
        return response()->json(['message' => 'No Product  found'], 201);
    }
    public function store(StoreProductReviewRequest $request)
    {

        $data = $request->all();
        if ($request->hasFile('image1')) {
            $data['image1'] = Storage::disk('public')->put('/', $request->file('image1'));
        }
        if ($request->hasFile('image2')) {
            $data['image2'] = Storage::disk('public')->put('/', $request->file('image2'));
        }
        if ($request->hasFile('image3')) {
            $data['image3'] = Storage::disk('public')->put('/', $request->file('image3'));
        }
        $productReview = ProductReview::create($data);

        if ($productReview) {
            return response()->json(['message' => 'Product Review Stored Successfully '], 200);
        } else {
            return response()->json(['message' => 'Product Review Not Stored'], 201);
        }
    }
    public function edit(int $id)
    {
        $productReview = ProductReview::find($id);
        if ($productReview) {
            return new ProductReviewEditResource($productReview);
        } else {
            return response()->json(['message' => 'Product Review not found'], 201);
        }
    }

    public function update(UpdateProductReviewRequest $request, int $id)
    {
        $productReview  = ProductReview::find($id);
        if ($productReview) {
            $data = [
                'product_id' => $request->product_id,
                'user_id' => $request->user_id,
                'rating' => $request->rating,
                'review' => $request->review,
                'status' => $request->status,
            ];
            if ($request->hasFile('image1')) {
                if (!is_null($productReview->image1)) {
                    Storage::delete($productReview->image1);
                }
                $data['image1'] = Storage::disk('public')->put('/', $request->file('image1'));
            }
            if ($request->hasFile('image2')) {
                if (!is_null($productReview->image2)) {
                    Storage::delete($productReview->image2);
                }
                $data['image2'] = Storage::disk('public')->put('/', $request->file('image2'));
            }
            if ($request->hasFile('image3')) {
                if (!is_null($productReview->image3)) {
                    Storage::delete($productReview->image3);
                }
                $data['image3'] = Storage::disk('public')->put('/', $request->file('image3'));
            }
            $productReview->update($data);
            return response()->json(['message' => 'Product Review updated successfully.'], 200);
        } else {
            return response()->json(['message' => 'Product Review not found.'], 201);
        }
    }

    public function destroy(int $id)
    {
        $productReview  = ProductReview::find($id);
        if ($productReview) {
            $productReview->delete();
            return response()->json(['message' => 'Product Review Deleted Successfully'], 200);
        } else {
            return response()->json(['message' => 'Product Review not found.'], 201);
        }
    }
}
