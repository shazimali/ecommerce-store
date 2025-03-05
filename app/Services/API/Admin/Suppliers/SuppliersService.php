<?php

namespace App\Services\API\Admin\Suppliers;

use App\Http\Requests\API\Admin\Suppliers\StoreSupplierRequest;
use App\Http\Requests\API\Admin\Suppliers\UpdateSupplierRequest;
use App\Http\Resources\API\Admin\Suppliers\SupplierEditResource;
use App\Http\Resources\API\Admin\Suppliers\SupplierListResource;
use App\Interfaces\API\Admin\Suppliers\SuppliersInterface;
use App\Models\Supplier;
use Illuminate\Http\Request;

class SuppliersService implements SuppliersInterface
{

    public function getAll(Request $request)
    {
        $itemPerPage = $request->get('item_per_page', 5);
        $supplier = Supplier::paginate($itemPerPage);
        if ($supplier) {
            return SupplierListResource::collection($supplier);
        } else {
            return response()->json(['message' => 'Supplier Not found'], 201);
        }
    }

    public function store(StoreSupplierRequest $request)
    {
        $supplier = Supplier::create($request->all());
        if ($supplier) {
            return response()->json(['message' => 'Supplier Data Stored Successfully.'], 200);
        } else {
            return response()->json(['message' => 'Supplier  Not Stored.'], 201);
        }
    }

    public function edit(int $id)
    {
        $supplier = Supplier::find($id);
        if ($supplier) {
            return new  SupplierEditResource($supplier);
        } else {
            return response()->json(['message' => 'Supplier not found.'], 201);
        }
    }

    public function update(UpdateSupplierRequest $request, int $id)
    {
        $supplier = Supplier::find($id);
        if ($supplier) {
            $data = [
                'name' => $request->name,
                'email' => $request->email,
                'address' => $request->address,
                'phone' => $request->phone,
            ];
            $supplier->update($data);
            return response()->json(['message' => 'Supplier Data Updated Successfully.'], 200);
        } else {
            return response()->json(['message' => 'Supplier not found.'], 201);
        }
    }

    public function destroy(int $id)
    {
        $supplier = Supplier::find($id);
        if ($supplier) {
            $supplier->delete($supplier);
            return response()->json(['message' => 'Supplier Data Deleted Successfully.'], 200);
        } else {
            return response()->json(['message' => 'Supplier not found.'], 201);
        }
    }
}
