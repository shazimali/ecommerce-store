<?php

namespace App\Http\Resources\API\Admin\Categories;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Storage;

class CategoryListResource extends JsonResource
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
            'image' => Env('APP_URL') . Storage::url($this->image),
            'order' => $this->order,
            'created_at' => $this->created_at->toDateString(),
            'websites' =>  $this->websites->pluck('title')
        ];
    }
}
