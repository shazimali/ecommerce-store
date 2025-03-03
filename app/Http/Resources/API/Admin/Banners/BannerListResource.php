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
            'btn_text' => $this->slug,
            'btn_link' => $this->slug,
            'image' => Env('APP_URL') . Storage::url($this->image),
            'mob_image' => $this->mob_image,
            'order' => $this->order,
            'created_at' => $this->created_at->toDateString(),
            'websites' =>  $this->websites->pluck('title')
        ];
    }
}
