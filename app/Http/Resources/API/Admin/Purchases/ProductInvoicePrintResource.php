<?php

namespace App\Http\Resources\API\Admin\Purchases;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ProductInvoicePrintResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->product->id,
            'title' => $this->product->title,
            'qty' => $this->qty,
            'price' => $this->net_price,
            'color' => $this->color ? $this->color->color_name : 'N/A',
            'code' => $this->product->code,
            'sku' => $this->product->sku
        ];
    }
}
