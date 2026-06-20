<?php

namespace App\Http\Requests\API\Admin\Bundles;

use App\Http\Requests\JsonFormRequest;

class StoreBundleRequest extends JsonFormRequest
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
                'unique:bundles,title'
            ],
            'slug' => [
                'required',
                'unique:bundles,slug'
            ],
            'sku' => [
                'required',
                'unique:bundles,sku'
            ],
            'order' => 'required|numeric',
            'short_desc' => 'required',
            'description' => 'required',
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
