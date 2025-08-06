<?php

namespace App\Http\Resources\API\Admin\Collections;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Storage;

class CollectionEditResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return  [
            'id' => $this->id,
            'title' => $this->title,
            'slug' => $this->slug,
            'order' => $this->order,
            'status' => $this->status,
            'position' => $this->position,
            'image_src' => $this->image ? getWebsiteUrl() . Storage::url($this->image) : '',
            'mob_image_src' => $this->mob_image ? getWebsiteUrl() . Storage::url($this->mob_image) : '',
            'websites' => $this->websites,
            'products' => $this->products,
        ];
    }
}
