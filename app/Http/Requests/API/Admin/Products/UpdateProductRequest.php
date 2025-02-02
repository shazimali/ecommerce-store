<?php

namespace App\Http\Requests\API\Admin\Products;

use Illuminate\Foundation\Http\FormRequest;

class UpdateProductRequest extends FormRequest
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
            ],
            'sku' => [
                'required',
                'unique:product_heads,sku'
            ],
            'order' => 'required',
            'short_desc' => 'required',
            'discount' => 'required',
            'description' => 'required',
            'youtube_link' => 'required',
            'seo_title' => 'required',
            'seo_desc' => 'required',
            'status' => 'required',
            'image' => 'required',

        ];
    }
}
