<?php

namespace App\Interfaces\API\Admin\Orders;

use App\Http\Requests\API\Admin\Orders\BookOrderRequest;
use Illuminate\Http\Request;

interface OrdersInterface
{
    public function getAll(Request $request);
    public function getAllCODs();
    public function bookOrder(BookOrderRequest $request);
    public function deleteOrder(int $id);
}
