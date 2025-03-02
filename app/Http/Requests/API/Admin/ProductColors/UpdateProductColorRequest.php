<?php

namespace App\Http\Requests\API\Admin\ProductColors;

use Illuminate\Foundation\Http\FormRequest;

class UpdateProductColorRequest extends FormRequest
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
            'product_head_id' => 'required',
            'color_name' => 'required',
            'color_image' => 'required',
            'image1' => 'required',
        ];
    }

    public function messages(): array
    {
        return [
            'product_head_id.required' => 'Product field is required.',

        ];
    }
}
