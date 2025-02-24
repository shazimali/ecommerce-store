<?php

namespace App\Http\Resources\API\Admin\SubCategories;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Storage;

class SubCategoryEditResource extends JsonResource
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
            'order' => $this->order,
            'categories' => $this->categories

        ];
    }
}
