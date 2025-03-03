<?php

namespace App\Http\Resources\API\Admin\Products;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ProductPricesListResource extends JsonResource
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
            'price' => $this->price,
            'product' => $this->product_head->title,
            'product_id' => $this->product_head->id,
            'country' => $this->country->name,
            'discount' => $this->discount,
            'discount_from' => $this->discount_from,
            'discount_to' => $this->discount_to
        ];
    }
}
