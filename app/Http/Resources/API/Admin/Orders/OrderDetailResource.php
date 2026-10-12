<?php

namespace App\Http\Resources\API\Admin\Orders;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Storage;

class OrderDetailResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        $coupon_discount = $this->coupon ? $this->coupon->discount : 0;

        return [
            'id' => $this->id,
            'order_id' => $this->order_id,
            'status' => $this->status,
            'created_at' => $this->created_at->toDateTimeString(),
            'customer_name' => $this->user ? $this->user->name : '',
            'customer_email' => $this->user ? $this->user->email : $this->email,
            'phone' => $this->phone,
            'address' => $this->address,
            'billing_address' => $this->billing_address,
            'country' => $this->country ? $this->country->name : '',
            'city' => $this->city ? $this->city->name : '',
            'special_instructions' => $this->special_instructions,
            'cod_company' => $this->cod ? $this->cod->title : '',
            'track_number' => $this->track_number,
            'slip_link' => $this->slip_link,
            'sub_total' => $this->sub_total,
            'free_shipping' => $this->free_shipping,
            'shipping_charges' => $this->shipping_charges,
            'code' => $this->coupon ? $this->coupon->code : '',
            'discount' => $coupon_discount,
            'discount_amount' => round($this->sub_total / 100 * $coupon_discount),
            'total' => $this->total,
            'items' => $this->detail->map(function ($item) {
                $is_bundle = !empty($item->bundle_id);
                $source = $is_bundle ? $item->bundle : $item->product;
                $color = $is_bundle ? $item->bundle_color : $item->color;
                $image = $color && $color->color_image ? $color->color_image : ($source ? $source->image : null);

                return [
                    'id' => $item->id,
                    'is_bundle' => $is_bundle,
                    'title' => $source ? $source->title : 'Deleted item',
                    'sku' => $source ? $source->sku : '',
                    'color' => $color ? $color->color_name : '',
                    'image' => $image ? Env('APP_URL') . Storage::url($image) : '',
                    'currency' => $item->currency,
                    'unit_amount' => $item->unit_amount,
                    'quantity' => $item->quantity,
                    'total_amount' => $item->total_amount,
                ];
            }),
        ];
    }
}
