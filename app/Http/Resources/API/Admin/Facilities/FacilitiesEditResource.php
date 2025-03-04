<?php

namespace App\Http\Resources\API\Admin\Facilities;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class FacilitiesEditResource extends JsonResource
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
            'countries' => $this->countries
        ];
    }
}
