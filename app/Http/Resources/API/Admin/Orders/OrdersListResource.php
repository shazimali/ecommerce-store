<?php

namespace App\Http\Resources\API\Admin\Orders;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class OrdersListResource extends JsonResource
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
            'order_id' => $this->order_id,
            'sub_total' => $this->sub_total,
            'total' => $this->total,
            'country' => $this->country->name,
            'city' => $this->city->name,
            'free_shipping' => $this->free_shipping,
            'shipping_charges' => $this->shipping_charges,
            'code' => $this->coupon ? $this->coupon->code : 'N/A',
            'discount' => $this->coupon ? $this->coupon->discount . '%' : 0,
            'created_at' => $this->created_at->toDateString(),
            'status' => $this->status,
            'customer_name' => $this->user->name,
            'customer_email' => $this->user->email,
        ];
    }
}
