<?php

namespace App\Http\Resources\API\Admin\Bundles;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class BundlePricesEditResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return parent::toArray($request);
    }
}
