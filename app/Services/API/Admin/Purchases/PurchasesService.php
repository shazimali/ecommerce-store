<?php

namespace App\Services\API\Admin\Purchases;

use App\Http\Requests\API\Admin\Purchases\StorePurchaseRequest;
use App\Http\Requests\API\Admin\Purchases\UpdatePurchaseRequest;
use App\Http\Resources\API\Admin\Products\ProductListResource;
use App\Http\Resources\API\Admin\Purchases\PurchaseProductsListResource;
use App\Http\Resources\API\Admin\Purchases\PurchasesEditResource;
use App\Http\Resources\API\Admin\Purchases\PurchasesListResource;
use App\Http\Resources\API\Admin\Suppliers\SupplierListResource;
use App\Interfaces\API\Admin\Purchases\PurchasesInterface;
use App\Models\ProductHead;
use App\Models\Purchase;
use App\Models\PurchaseDetail;
use App\Models\Supplier;
use Illuminate\Http\Request;
use PhpParser\Node\Stmt\Else_;

class PurchasesService implements PurchasesInterface
{
    public function getAll(Request $request)
    {
        
        $search = $request->search;
        $supplierId = $request->supplier_id;
        $invoiceId = $request->invoice_id;

        $query = Purchase::query()->with('supplier');

        $query->when($search, function ($q) use ($search) {
            return $q->where('name', 'like', "%{$search}%")
                ->orWhere('id', 'like', "%{$search}%");
        });

        $query->when($supplierId, function ($q) use ($supplierId) {
            return $q->where('supplier_id', $supplierId);
        });

        $query->when($invoiceId, function ($q) use ($invoiceId) {
            return $q->where('invoice_id', $invoiceId);
        });

        return PurchasesListResource::collection($query->paginate($request->item_per_page));
    }

    public function getAllSuppliers()
    {
        $products = ProductHead::active()->with('colors')->get();
        $lstProducts = [];
        $list_id = 0;
        foreach ($products as $product_key => $product) {
            if (count($product->colors)) {
                foreach ($product->colors as $color_key => $color) {
                    $data = [
                        'list_id' => $list_id++,
                        'product_id' => $product->id,
                        'product_title' => $product->title,
                        'product_code' => $product->code,
                        'color_name' => $color->color_name,
                        'color_id' => $color->id
                    ];
                    array_push($lstProducts, $data);
                }
            } else {
                $data = [
                    'list_id' => $list_id++,
                    'product_id' => $product->id,
                    'product_title' => $product->title,
                    'product_code' => $product->code,
                    'color_name' => 'N/A',
                    'color_id' => 0
                ];
                array_push($lstProducts, $data);
            }
        }
        $suppliers = Supplier::all();

        if ($suppliers) {
            return [
                'suppliers' => SupplierListResource::collection($suppliers),
                'products' => $lstProducts
            ];
        }
        return response()->json(['message' => 'Suppliers Not Found.'], 201);
    }


    public function store(StorePurchaseRequest $request)
    {
        $purchase_data = $request->except(['list_id', 'purchase_detail', 'product_id']);
        $purchase_data['invoice_id'] = Purchase::get()->count() > 0 ? Purchase::get()->last()->invoice_id + 1 : 1000;
        $purchase = Purchase::create($purchase_data);
        if ($purchase) {
            foreach ($request->purchase_detail as $key => $purchase_detail) {
                $detail = new PurchaseDetail();
                $detail->purchase_id = $purchase->id;
                $detail->product_head_id = $purchase_detail['id'];
                $detail->product_color_id = $purchase_detail['product_color_id'];
                $detail->qty = $purchase_detail['qty'];
                $detail->net_price = $purchase_detail['net_price'];
                $detail->save();
            }
        }
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
                'invoice_date' => $request->invoice_date,
                'supplier_id' => $request->supplier_id,
                'total_qty' => $request->total_qty,
                'total_price' => $request->total_price,
            ];
            $purchase->update($data);
            PurchaseDetail::where('purchase_id', $id)->delete();
            foreach ($request->purchase_detail as $key => $purchase_detail) {
                $detail = new PurchaseDetail();
                $detail->purchase_id = $purchase->id;
                $detail->product_head_id = $purchase_detail['id'];
                $detail->product_color_id = $purchase_detail['product_color_id'];
                $detail->qty = $purchase_detail['qty'];
                $detail->net_price = $purchase_detail['net_price'];
                $detail->save();
            }
            return response()->json(['message' => 'Purchase Updated Successfully.'], 200);
        } else {
            return response()->json(['message' => 'Purchase not found'], 201);
        }
    }

    public function destroy(int $id)
    {
        $purchase = Purchase::find($id);
        if ($purchase) {
            PurchaseDetail::where('purchase_id', $id)->delete();
            $purchase->delete();
            return response()->json(['message' => 'Purchased data deleted Successfully.'], 200);
        } else {
            return response()->json(['message' => 'Purchase not found'], 201);
        }
    }
}
