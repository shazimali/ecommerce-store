<?php

namespace App\Http\Resources\API\Admin\Pages;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class PagesEditResource extends JsonResource
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
            'content' => $this->content,
            'status' => $this->status,
            'seo_title' => $this->seo_title,
            'seo_description' => $this->seo_description,
            'countries' => $this->countries,

        ];
    }
}
