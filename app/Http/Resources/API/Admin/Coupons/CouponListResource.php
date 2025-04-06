<?php

namespace App\Http\Resources\API\Admin\Coupons;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CouponListResource extends JsonResource
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
            'code' => $this->code,
            'discount' => $this->discount,
            'date_from' => $this->date_from,
            'date_to' => $this->date_to,
            'country_id' => $this->country_id,
            'country' => $this->country->name,
            'created_at' => $this->created_at->toDateString(),


        ];
    }
}
