<?php

namespace App\Http\Resources\API\Admin\ProductColors;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ProductColorEditResource extends JsonResource
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
            'product_head_id' => $this->product_head_id,
            'color_name' => $this->color_name,
            'color_image' => $this->color_image,
            'image1' => $this->image1,
            'image2' => $this->image2,
            'image3' => $this->image3,
            'image4' => $this->image4,
            'image5' => $this->image5,

        ];
    }
}
