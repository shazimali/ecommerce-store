<?php

namespace App\Services\API\Admin\Customers;

use App\Http\Resources\API\Admin\Customers\CustomersListResource;
use App\Interfaces\API\Admin\Customers\CustomersInterface;
use App\Models\User;
use Illuminate\Http\Request;

class CustomersService implements CustomersInterface
{
    public function getAll(Request $request)
    {
        $customer = User::paginate($request->item_per_page);
        if ($customer) {
            return CustomersListResource::collection($customer);
        }
        return response()->json(['message' => 'Customer Not Found'], 201);
    }
}
