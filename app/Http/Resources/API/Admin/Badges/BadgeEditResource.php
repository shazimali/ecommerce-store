<?php

namespace App\Http\Resources\API\Admin\Badges;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Storage;

class BadgeEditResource extends JsonResource
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
            'image' => env('APP_URL') . Storage::url($this->image),
            'status' => $this->status,
            'sub_categories' => $this->sub_categories->pluck('id')
        ];
    }
}
