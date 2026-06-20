<?php

namespace App\Services;

use App\Models\Order;
use App\Models\OrderDetail;
use App\Models\ProductHead;
use App\Models\ProductReview;
use Illuminate\Support\Facades\Auth;

class ReviewService
{


    static public function getToBeReviews()
    {
        $orders = Order::where('user_id', Auth::id())->get();
        $order_detail = OrderDetail::whereIn('order_id', $orders->pluck('id'))->get();
        
        $products_already_reviewed = ProductReview::whereIn('product_id', $order_detail->whereNotNull('product_id')->pluck('product_id'))
            ->whereNotNull('product_id')
            ->where('user_id', Auth::id())
            ->get();

        $bundles_already_reviewed = ProductReview::whereIn('bundle_id', $order_detail->whereNotNull('bundle_id')->pluck('bundle_id'))
            ->whereNotNull('bundle_id')
            ->where('user_id', Auth::id())
            ->get();

        $toBeReviewedProducts = ProductHead::whereIn('id', $order_detail->whereNotNull('product_id')->pluck('product_id'))
            ->whereNotIn('id', $products_already_reviewed->pluck('product_id'))->get()
            ->map(function($item) {
                $item->is_bundle = false;
                return $item;
            });

        $toBeReviewedBundles = \App\Models\Bundle::whereIn('id', $order_detail->whereNotNull('bundle_id')->pluck('bundle_id'))
            ->whereNotIn('id', $bundles_already_reviewed->pluck('bundle_id'))->get()
            ->map(function($item) {
                $item->is_bundle = true;
                return $item;
            });

        return $toBeReviewedProducts->concat($toBeReviewedBundles);
    }

    static public function getReviewsHistory()
    {
        $orders = Order::where('user_id', Auth::id())->get();
        $orderDetails = OrderDetail::whereIn('order_id', $orders->pluck('id'))->get();
        $productIds = $orderDetails->whereNotNull('product_id')->pluck('product_id');
        $bundleIds = $orderDetails->whereNotNull('bundle_id')->pluck('bundle_id');
        
        $reviews = ProductReview::with(['product', 'bundle'])
            ->where('user_id', Auth::id())
            ->where(function($query) use ($productIds, $bundleIds) {
                $query->whereIn('product_id', $productIds)
                      ->orWhereIn('bundle_id', $bundleIds);
            })->get();

        return $reviews;
    }
}
