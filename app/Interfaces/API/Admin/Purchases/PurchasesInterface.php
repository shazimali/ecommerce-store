<?php

namespace App\Interfaces\API\Admin\Purchases;


use App\Http\Requests\API\Admin\Purchases\StorePurchaseRequest;
use App\Http\Requests\API\Admin\Purchases\UpdatePurchaseRequest;
use Illuminate\Http\Request;

interface PurchasesInterface
{
    public function getAll(Request $request);
    public function getAllSuppliers();
    public function getPurchaseInvoiceForPrint(Request $request, int $id);
    public function store(StorePurchaseRequest $request);
    public function edit(int $id);
    public function update(UpdatePurchaseRequest $request, int $id);
    public function destroy(int $id);
}
