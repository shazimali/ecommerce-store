<?php

namespace App\Http\Controllers\API\Admin\Orders;

use App\Http\Controllers\Controller;
use App\Http\Requests\API\Admin\Orders\BookOrderRequest;
use App\Services\API\Admin\Orders\OrdersService;
use Illuminate\Http\Request;
use Ramsey\Uuid\Type\Integer;

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

    public function CODList()
    {
        $this->authorize('order_access');

        return $this->ordersService->getAllCODs();
    }

    public function bookOrder(BookOrderRequest $request)
    {
        $this->authorize('order_access');

        return $this->ordersService->bookOrder($request);
    }

    public function deleteOrder(int $id)
    {
        $this->authorize('order_access');

        return $this->ordersService->deleteOrder($id);
    }
}
