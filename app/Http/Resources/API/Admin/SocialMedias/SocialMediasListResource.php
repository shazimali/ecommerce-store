<?php

namespace App\Http\Resources\API\Admin\SocialMedias;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class SocialMediasListResource extends JsonResource
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
            'class' => $this->class,
            'url' => $this->url,
            'created_at' => $this->created_at->toDateString(),

        ];
    }
}
