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
            'product_head_id' => $this->product_head_id,
            'title' => $this->product->title,
            'code' => $this->product->code,
            'color_name' => $this->color ? $this->color->color_name : 'N/A',
            'color_id' => $this->product_color_id,
            'qty' => $this->qty,
            'net_price' => $this->net_price,

        ];
    }
}
