<?php

namespace App\Http\Resources\API\Admin\Products;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Storage;

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
            'sub_categories' => $this->sub_categories,
            'is_new' => $this->is_new == 1 ? true : false,
            'is_featured' => $this->is_featured == 1 ? true : false,
            'coming_soon' => $this->coming_soon == 1 ? true : false,
            'nav_image' => $this->nav_image,
            'mobile_image' => $this->mobile_image,
            'image_src' => $this->image ? Env('APP_URL') . Storage::url($this->image) : '',
            'created_at' => $this->created_at->toDateString()
        ];
    }
}
