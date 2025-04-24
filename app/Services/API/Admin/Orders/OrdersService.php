<?php

namespace App\Services\API\Admin\Orders;

use App\Http\Resources\API\Admin\Orders\OrdersListResource;
use App\Interfaces\API\Admin\Orders\OrdersInterface;
use App\Models\Order;
use Illuminate\Http\Request;

class OrdersService implements OrdersInterface
{
    public function getAll(Request $request)
    {

        $perPage = $request->itemPerPage;
        $order = Order::with('coupon', 'user')->paginate($perPage);
        if ($order) {
            return OrdersListResource::collection($order);
        } else {
            return response()->json(['message' => 'Order Not exist'], 200);
        }
    }
}
