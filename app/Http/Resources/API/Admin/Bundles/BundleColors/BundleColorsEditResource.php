<?php

namespace App\Http\Resources\API\Admin\Bundles\BundleColors;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class BundleColorsEditResource extends JsonResource
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
            'bundle_id' => $this->bundle_id,
            'color_name' => $this->color_name,
            'color_image' => $this->color_image,
            'image1' => $this->image1,
            'image2' => $this->image2,
            'image3' => $this->image3,
            'image4' => $this->image4,
            'image5' => $this->image5,
        ];
    }
}
