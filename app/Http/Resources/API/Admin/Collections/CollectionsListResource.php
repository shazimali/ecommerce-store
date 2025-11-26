<?php

namespace App\Http\Resources\API\Admin\Collections;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Storage;

class CollectionsListResource extends JsonResource
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
            'image' => getWebsiteUrl() . Storage::url($this->image),
            'mob_image' => getWebsiteUrl() . Storage::url($this->mob_image),
            'order' => $this->order,
            'status' => $this->status,
            'position' => $this->position,
            'created_at' => $this->created_at->toDateString(),
            'websites' =>  $this->websites->pluck('title'),
            'products' =>  $this->products->pluck('title'),
        ];
    }
}
