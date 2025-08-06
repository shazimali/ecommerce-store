<?php

namespace App\Http\Resources\API\Admin\Banners;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Storage;

class BannerListResource extends JsonResource
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
            'heading' => $this->slug,
            'sub_heading' => $this->slug,
            'btn_text' => $this->btn_text,
            'btn_link' => $this->btn_link,
            'image' => getWebsiteUrl() . Storage::url($this->image),
            'mob_image' => getWebsiteUrl() . Storage::url($this->mob_image),
            'order' => $this->order,
            'created_at' => $this->created_at->toDateString(),
            'websites' =>  $this->websites->pluck('title')
        ];
    }
}
