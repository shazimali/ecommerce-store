<?php

namespace App\Http\Resources\API\Admin\Facilities;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class FacilitiesListResource extends JsonResource
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
            'created_at' => $this->created_at->toDateString(),
            'countries' => $this->countries->pluck('name'),
        ];
    }
}
