<?php

namespace App\Http\Requests\API\Admin\ProductReviews;

use App\Http\Requests\JsonFormRequest;
use Illuminate\Foundation\Http\FormRequest;

class StoreProductReviewRequest extends JsonFormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'product_id' => 'required',
            'rating' => 'required',
            'review' => 'required',
            'status' => 'required',
            'image1' => 'nullable|image|max:500',
            'image2' => 'nullable|image|max:500',
            'image3' => 'nullable|image|max:500',
        ];
    }

    public function messages()
    {
        return [
            'product_id.required' => 'Product name is required'
        ];
    }
}
