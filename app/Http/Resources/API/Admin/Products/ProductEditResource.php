<?php

namespace App\Http\Resources\API\Admin\Products;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ProductEditResource extends JsonResource
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
            'title' => $this->title,
            'slug' => $this->slug,
            'code' => $this->code,
            'sku' => $this->sku,
            'order' => $this->order,
            'short_desc' => $this->short_desc,
            'discount' => $this->discount,
            'description' => $this->description,
            'youtube_link' => $this->youtube_link,
            'seo_title' => $this->seo_title,
            'seo_desc' => $this->seo_desc,
            'status' => $this->status,
            'is_new' => $this->is_new,
            'is_featured' => $this->is_featured,
            'coming_soon' => $this->coming_soon,
            'nav_image' => $this->nav_image,
            'mobile_image' => $this->mobile_image,
            'image' => $this->image,
            'created_at' => $this->created_at->toDateString()
        ];
    }
}
