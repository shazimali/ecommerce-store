<?php

namespace App\Http\Resources\API\Admin\Purchases;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class PurchasesEditResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'invoice_id' => $this->invoice_id,
            'invoice_date' => $this->invoice_date,
            'supplier_id' => $this->supplier_id,
            'total_qty' => $this->total_qty,
            'total_price' => $this->total_price,
            'purchase_detail' => PurchaseDetailsResource::collection($this->purchaseDetails)
        ];
    }
}
