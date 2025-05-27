<?php

namespace App\Services\API\Admin\Orders;

use App\Http\Resources\API\Admin\Orders\OrderCODListResource;
use App\Http\Resources\API\Admin\Orders\OrdersListResource;
use App\Interfaces\API\Admin\Orders\OrdersInterface;
use App\Models\CashOnDelivery;
use App\Models\Order;
use Illuminate\Http\Request;

class OrdersService implements OrdersInterface
{
    public function getAll(Request $request)
    {
        $order = Order::with('coupon', 'user')->orderBy('created_at', 'DESC')->paginate($request->itemPerPage);
        if ($order) {
            return OrdersListResource::collection($order);
        } else {
            return response()->json(['message' => 'Order Not exist'], 200);
        }
    }

    public function getAllCODs()
    {
        $cods = CashOnDelivery::activeOrDefault()->get();
        if ($cods) {
            return OrderCODListResource::collection($cods);
        } else {
            return response()->json(['message' => 'COD not found'], 200);
        }
    }
}
