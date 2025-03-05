<?php

namespace App\Interfaces\API\Admin\Suppliers;

use App\Http\Requests\API\Admin\Suppliers\StoreSupplierRequest;
use App\Http\Requests\API\Admin\Suppliers\UpdateSupplierRequest;
use Illuminate\Http\Request;

interface SuppliersInterface
{
    public function getAll(Request $request);
    public function store(StoreSupplierRequest $request);
    public function edit(int $id);
    public function update(UpdateSupplierRequest $request, int $id);
    public function destroy(int $id);
}
