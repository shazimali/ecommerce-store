<?php

namespace App\Http\Requests\API\Admin\Bundles;

use Illuminate\Foundation\Http\FormRequest;

class UpdateBundleRequest extends FormRequest
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
                'unique:bundles,title,' . $this->route('id'),
            ],
            'slug' => [
                'required',
                'unique:bundles,slug,' . $this->route('id'),
            ],
            'sku' => [
                'required',
                'unique:bundles,sku,' . $this->route('id'),
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
