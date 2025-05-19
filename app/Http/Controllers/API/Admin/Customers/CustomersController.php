<?php

namespace App\Http\Controllers\API\Admin\Customers;

use App\Http\Controllers\Controller;
use App\Services\API\Admin\Customers\CustomersService;
use Illuminate\Http\Request;

class CustomersController extends Controller
{
    public $customersService;

    public function __construct(CustomersService $customersService)
    {
        $this->customersService = $customersService;
    }

    public function index(Request $request)
    {
        $this->authorize('customer_access');
        return $this->customersService->getAll($request);
    }
}
