<?php

namespace App\Http\Resources\API\Admin\Banners;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Storage;

class BannerEditResource extends JsonResource
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
            'heading' => $this->heading,
            'sub_heading' => $this->sub_heading,
            'btn_text' => $this->btn_text,
            'btn_link' => $this->btn_link,
            'image_src' => $this->image ? Env('APP_URL') . Storage::url($this->image) : '',
            'mob_image_src' => $this->mob_image ? Env('APP_URL') . Storage::url($this->mob_image) : '',
            'order' => $this->order,
            'websites' =>  $this->websites
        ];
    }
}
