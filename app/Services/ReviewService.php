<?php

namespace App\services;

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
        $products_already_reviewed = ProductReview::whereIn('product_id', $order_detail->pluck('product_id'))
            ->where('user_id', Auth::id())
            ->get();
        return ProductHead::whereIn('id', $order_detail->pluck('product_id'))
            ->whereNotIn('id', $products_already_reviewed->pluck('product_id'))->get();
    }

    static public function getReviewsHistory()
    {
        return [];
    }
}
