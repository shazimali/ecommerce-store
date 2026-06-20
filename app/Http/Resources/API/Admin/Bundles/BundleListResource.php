<?php

namespace App\Http\Resources\API\Admin\Bundles;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Storage;

class BundleListResource extends JsonResource
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
            'sku' => $this->sku,
            'order' => $this->order,
            'short_desc' => $this->short_desc,
            'discount' => $this->discount,
            'description' => $this->description,
            'youtube_link' => $this->youtube_link,
            'seo_title' => $this->seo_title,
            'colors' => $this->colors->pluck('id', 'color_name'),
            'seo_desc' => $this->seo_desc,
            'status' => $this->status,
            'coming_soon' => $this->coming_soon,
            'nav_image' => $this->nav_image,
            'mobile_image' => $this->mobile_image,
            'image' => Env('APP_URL') . Storage::url($this->image),
            'created_at' => $this->created_at->toDateString()
        ];
    }
}
