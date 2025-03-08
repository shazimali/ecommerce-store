<?php

namespace App\Services\API\Admin\Purchases;

use App\Http\Requests\API\Admin\Purchases\StorePurchaseRequest;
use App\Http\Requests\API\Admin\Purchases\UpdatePurchaseRequest;
use App\Http\Resources\API\Admin\Purchases\PurchasesEditResource;
use App\Http\Resources\API\Admin\Purchases\PurchasesListResource;
use App\Interfaces\API\Admin\Purchases\PurchasesInterface;
use App\Models\Purchase;
use Illuminate\Http\Request;

class PurchasesService implements PurchasesInterface
{
    public function getAll(Request $request)
    {
        $itemPerPage = $request->get('item_per_page', 5);

        // Eager load purchaseDetails with purchase_id
        $purchase = Purchase::with(['purchaseDetails.purchase_id'])
            ->paginate($itemPerPage);

        return PurchasesListResource::collection($purchase);
    }

    public function store(StorePurchaseRequest $request)
    {
        $purchase = Purchase::create($request->all());
        if ($purchase) {
            return response()->json(['message' => 'Purchase Stored Successfully.'], 200);
        } else {
            return response()->json(['message' => 'Purchase Not Stored'], 201);
        }
    }

    public function edit(int $id)
    {
        $purchase = Purchase::find($id);
        if ($purchase) {
            return new PurchasesEditResource($purchase);
        } else {
            return response()->json(['message' => 'Purchase not found'], 201);
        }
    }

    public function update(UpdatePurchaseRequest $request, int $id)
    {
        $purchase = Purchase::find($id);
        if ($purchase) {
            $data = [
                'invoice_id' => $request->invoice_id,
                'invoice_date' => $request->invoice_date,
                'supplier_id' => $request->supplier_id,
                'total_qty' => $request->total_qty,
                'total_price' => $request->total_price,
            ];
            $purchase->update($data);
            return response()->json(['message' => 'Purchased data Updated Successfully.'], 200);
        } else {
            return response()->json(['message' => 'Purchase not found'], 201);
        }
    }

    public function destroy(int $id)
    {
        $purchase = Purchase::find($id);
        if ($purchase) {
            $purchase->delete();
            return response()->json(['message' => 'Purchased data deleted Successfully.'], 200);
        } else {
            return response()->json(['message' => 'Purchase not found'], 201);
        }
    }
}
