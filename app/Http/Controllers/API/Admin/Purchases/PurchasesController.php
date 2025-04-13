<?php

namespace App\Http\Controllers\API\Admin\Purchases;

use App\Http\Controllers\Controller;
use App\Http\Requests\API\Admin\Purchases\StorePurchaseRequest;
use App\Http\Requests\API\Admin\Purchases\UpdatePurchaseRequest;
use App\Services\API\Admin\Purchases\PurchasesService;
use Illuminate\Http\Request;

class PurchasesController extends Controller
{
    public $purchasesService;

    public function __construct(PurchasesService $purchasesService)
    {
        $this->purchasesService = $purchasesService;
    }

    public function index(Request $request)
    {
        $this->authorize('purchase_access');
        return $this->purchasesService->getAll($request);
    }

    public function getAllSuppliers()
    {
        return $this->purchasesService->getAllSuppliers();
    }

    public function getInvoice(Request $request, int $id)
    {
        return $this->purchasesService->getPurchaseInvoiceForPrint($request, $id);
    }

    public function store(StorePurchaseRequest $request)
    {
        $this->authorize('purchase_create');
        return $this->purchasesService->store($request);
    }

    public function edit(int $id)
    {
        $this->authorize('purchase_edit');
        return $this->purchasesService->edit($id);
    }

    public function update(UpdatePurchaseRequest $request, int $id)
    {
        $this->authorize('purchase_edit');
        return $this->purchasesService->update($request, $id);
    }

    public function destroy(int $id)
    {
        $this->authorize('purchase_delete');
        return $this->purchasesService->destroy($id);
    }
}
