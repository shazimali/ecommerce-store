<?php

namespace App\Interfaces\API\Admin\Orders;

use App\Http\Requests\API\Admin\Orders\BookOrderRequest;
use App\Http\Requests\API\Admin\Orders\UpdateBookedOrderStatusRequest;
use Illuminate\Http\Request;

interface OrdersInterface
{
    public function getAll(Request $request);
    public function getAllCODs();
    public function bookOrder(BookOrderRequest $request);
    public function bookedOrderStatus(UpdateBookedOrderStatusRequest $request);
    public function deleteOrder(int $id);
}
