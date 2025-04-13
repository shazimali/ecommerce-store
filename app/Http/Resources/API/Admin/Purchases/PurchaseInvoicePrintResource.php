<?php

namespace App\Http\Resources\API\Admin\Purchases;

use App\Http\Resources\API\Admin\Products\ProductListResource;
use App\Http\Resources\API\Admin\Suppliers\SupplierListResource;
use App\Http\Resources\API\Admin\Suppliers\SupplierPrintResource;
use App\Http\Resources\API\Admin\Purchases\PurchaseDetailsPrintResource;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class PurchaseInvoicePrintResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'invoice_id' => $this->invoice_id,
            'invoice_date' => $this->invoice_date,
            'supplier' => new SupplierPrintResource($this->supplier),
            'products' => ProductInvoicePrintResource::collection($this->purchaseDetails),
            'total_qty' => $this->total_qty,
            'total_price' => $this->total_price,

        ];
    }
}
