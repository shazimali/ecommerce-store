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
                'unique:product_heads,title,' . $this->id,
            ],
            'slug' => [
                'required',
                'unique:product_heads,slug,' . $this->id,
            ],
            'code' => [
                'required',
                'unique:product_heads,code,' . $this->id,
            ],
            'sku' => [
                'required',
                'unique:product_heads,sku,' . $this->id,
            ],
            'order' => 'required|numeric',
            'short_desc' => 'required',
            'description' => 'required',
            'status' => 'required',
            'image' => 'nullable|image|max:500',


        ];
    }
}
