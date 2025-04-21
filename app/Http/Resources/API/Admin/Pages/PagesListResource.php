<?php

namespace App\Http\Resources\API\Admin\Pages;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class PagesListResource extends JsonResource
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
            'position' => $this->position,
            'created_at' => $this->created_at->toDateString(),
            'countries' => $this->countries->pluck('name'),
        ];
    }
}
