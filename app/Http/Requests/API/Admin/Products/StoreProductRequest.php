<?php

namespace App\Http\Requests\API\Admin\Products;

use App\Http\Requests\JsonFormRequest;
use Illuminate\Foundation\Http\FormRequest;

class StoreProductRequest extends JsonFormRequest
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
            'title' => [
                'required',
                'unique:product_heads,title'
            ],
            'slug' => [
                'required',
                'unique:product_heads,slug'
            ],
            'code' => [
                'required',
                'unique:product_heads,code'
            ],
            'sku' => [
                'required',
                'unique:product_heads,sku'
            ],
            'order' => 'required|numeric',
            'short_desc' => 'required',
            // 'discount' => 'required',
            'description' => 'required',
            // 'youtube_link' => 'required',
            // 'seo_title' => 'required',
            // 'seo_desc' => 'required',
            'status' => 'required',
            'image' => 'required|image|max:500',
            'image1' => 'nullable|image|max:500',
            'image2' => 'nullable|image|max:500',
            'image3' => 'nullable|image|max:500',
            'image4' => 'nullable|image|max:500',
            'image5' => 'nullable|image|max:500',

        ];
    }
}
