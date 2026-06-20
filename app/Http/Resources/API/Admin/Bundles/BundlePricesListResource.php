<?php

namespace App\Http\Resources\API\Admin\Bundles;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class BundlePricesListResource extends JsonResource
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
            'product' => $this->bundle->title,
            'product_id' => $this->bundle->id,
            'country' => $this->country->name,
            'discount' => $this->discount,
            'discount_from' => $this->discount_from,
            'discount_to' => $this->discount_to
        ];
    }
}
