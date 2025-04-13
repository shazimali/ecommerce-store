<?php

namespace App\Http\Resources\API\Admin\Purchases;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class PurchaseDetailsPrintResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'title' => $this->product->title,
            'color_name' => $this->color ? $this->color->color_name : 'N/A',
            'qty' => $this->qty,
            'net_price' => $this->net_price,

        ];
    }
}
