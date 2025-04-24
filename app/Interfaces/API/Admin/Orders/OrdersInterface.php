<?php

namespace App\Interfaces\API\Admin\Orders;

use Illuminate\Http\Request;

interface OrdersInterface
{
    public function getAll(Request $request);
}
