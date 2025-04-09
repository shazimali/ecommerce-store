<?php

namespace App\Http\Resources\API\Admin\Blogs;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Storage;

class BlogsEditResource extends JsonResource
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
            'image_src' => $this->image ? Env('APP_URL') . Storage::url($this->image) : '',
            'description' => $this->description,
            'seo_title' => $this->seo_title,
            'seo_desc' => $this->seo_desc,
            'status' => $this->status,
            'countries' => $this->countries,

        ];
    }
}
