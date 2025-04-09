<?php

namespace App\Http\Controllers\API\Admin\Suppliers;

use App\Http\Controllers\Controller;
use App\Http\Requests\API\Admin\Suppliers\StoreSupplierRequest;
use App\Http\Requests\API\Admin\Suppliers\UpdateSupplierRequest;
use App\Services\API\Admin\Suppliers\SuppliersService;
use Illuminate\Http\Request;

class SupplierController extends Controller
{
    public $suppliersService;

    public function __construct(SuppliersService $suppliersService)
    {
        $this->suppliersService = $suppliersService;
    }

    public function index(Request $request)
    {
        $this->authorize('supplier_access');
        return $this->suppliersService->getAll($request);
    }

    public function store(StoreSupplierRequest $request)
    {
        $this->authorize('supplier_create');
        return $this->suppliersService->store($request);
    }

    public function edit(int $id)
    {
        $this->authorize('supplier_edit');
        return $this->suppliersService->edit($id);
    }

    public function update(UpdateSupplierRequest $request, int $id)
    {
        $this->authorize('supplier_edit');
        return $this->suppliersService->update($request, $id);
    }

    public function destroy(int $id)
    {
        $this->authorize('supplier_delete');
        return $this->suppliersService->destroy($id);
    }
}
