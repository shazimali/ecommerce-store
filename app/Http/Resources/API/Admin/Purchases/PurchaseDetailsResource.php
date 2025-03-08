<?php

namespace App\Http\Resources\API\Admin\Purchases;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class PurchaseDetailsResource extends JsonResource
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
            'purchase_id' => $this->purchase_id,
            'product_head_id' => $this->product_head_id,
            'product_color_id' => $this->product_color_id,
            'qty' => $this->qty,
            'net_price' => $this->net_price,

        ];
    }
}
