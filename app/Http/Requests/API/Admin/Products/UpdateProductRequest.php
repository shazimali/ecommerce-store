<?php

namespace App\Http\Requests\API\Admin\Products;

use App\Http\Requests\JsonFormRequest;
use Illuminate\Validation\Rule;

class UpdateProductRequest extends JsonFormRequest
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
        $productId = $this->route('id');

        return [
            'title' => [
                'required',
                Rule::unique('product_heads', 'title')->ignore($productId),
            ],
            'slug' => [
                'required',
                Rule::unique('product_heads', 'slug')->ignore($productId),
            ],
            'code' => [
                'required',
                Rule::unique('product_heads', 'code')->ignore($productId),
            ],
            'sku' => [
                'required',
                Rule::unique('product_heads', 'sku')->ignore($productId),
            ],
            'order' => 'required|numeric',
            'short_desc' => 'required',
            'description' => 'required',
            'status' => 'required',
            'image' => 'nullable|image|max:500',
            'image1' => 'nullable|image|max:500',
            'image2' => 'nullable|image|max:500',
            'image3' => 'nullable|image|max:500',
            'image4' => 'nullable|image|max:500',
            'image5' => 'nullable|image|max:500',
        ];
    }
}

