<?php

namespace App\Http\Controllers\API\Admin\Orders;

use App\Http\Controllers\Controller;
use App\Services\API\Admin\Orders\OrdersService;
use Illuminate\Http\Request;

class OrdersController extends Controller
{
    public $ordersService;

    public function __construct(OrdersService $ordersService)
    {
        $this->ordersService = $ordersService;
    }

    public function index(Request $request)
    {
        $this->authorize('order_access');

        return $this->ordersService->getAll($request);
    }
}
