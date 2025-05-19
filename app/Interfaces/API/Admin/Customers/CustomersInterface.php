<?php

namespace App\Interfaces\API\Admin\Customers;

use Illuminate\Http\Request;

interface CustomersInterface
{
    public function getAll(Request $request);
}
