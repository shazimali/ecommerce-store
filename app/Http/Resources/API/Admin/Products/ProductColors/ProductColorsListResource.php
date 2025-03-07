<?php

namespace App\Http\Resources\API\Admin\Products\ProductColors;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Storage;

class ProductColorsListResource extends JsonResource
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
            'product_name' => $this->product_head->title,
            'color_name' => $this->color_name,
            'color_image_src' => $this->color_image ?  Env('APP_URL') . Storage::url($this->color_image) : '',
            'image1_src' => $this->image1 ?  Env('APP_URL') . Storage::url($this->image1) : '',
            'image2_src' => $this->image2 ?  Env('APP_URL') . Storage::url($this->image2) : '',
            'image3_src' => $this->image3 ?  Env('APP_URL') . Storage::url($this->image3) : '',
            'image4_src' => $this->image4 ?  Env('APP_URL') . Storage::url($this->image4) : '',
            'image5_src' => $this->image5 ?  Env('APP_URL') . Storage::url($this->image5) : '',
            'created_at' => $this->created_at->toDateString(),

        ];
    }
}
