<?php

namespace App\Http\Resources\API\Admin\ProductReviews;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Storage;

class ProductReviewEditResource extends JsonResource
{
    /**
     * Transform the resource into an array.up
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
            'image_src1' => $this->image1 ? Env('APP_URL') . Storage::url($this->image1) : '',
            'image_src2' => $this->image2 ? Env('APP_URL') . Storage::url($this->image2) : '',
            'image_src3' => $this->image3 ? Env('APP_URL') . Storage::url($this->image3) : '',
            'status' => $this->status
        ];
    }
}
