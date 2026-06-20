<?php

namespace App\Http\Requests\API\Admin\Bundles\BundleColors;

use App\Http\Requests\JsonFormRequest;

class StoreBundleColorsRequest extends JsonFormRequest
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
            'bundle_id' => 'required',
            'color_name' => 'required',
            'color_image' => 'required|image|max:500',
            'image1' => 'required|image|max:500',
            'image2' => 'nullable|image|max:500',
            'image3' => 'nullable|image|max:500',
            'image4' => 'nullable|image|max:500',
            'image5' => 'nullable|image|max:500',
        ];
    }

    public function messages(): array
    {
        return [
            'bundle_id.required' => 'Bundle field is required.',
        ];
    }
}
