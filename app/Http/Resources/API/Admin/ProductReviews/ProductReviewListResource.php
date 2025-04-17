<?php

namespace App\Http\Resources\API\Admin\ProductReviews;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Storage;

class ProductReviewListResource extends JsonResource
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
            'product' => $this->product->title,
            'user_id' => $this->user_id,
            'rating' => $this->rating,
            'review' => $this->review,
            'image1' =>  Env('APP_URL') . Storage::url($this->image1),
            'image2' =>  Env('APP_URL') . Storage::url($this->image2),
            'image3' =>  Env('APP_URL') . Storage::url($this->image3),
            'status' => $this->status,
            'created_at' => $this->created_at->toDateString()

        ];
    }
}
