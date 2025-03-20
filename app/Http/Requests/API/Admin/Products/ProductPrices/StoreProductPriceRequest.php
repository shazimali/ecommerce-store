<?php

namespace App\Http\Requests\API\Admin\Products\ProductPrices;

use App\Http\Requests\JsonFormRequest;
use Illuminate\Foundation\Http\FormRequest;

class StoreProductPriceRequest extends JsonFormRequest
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
            'country_id' => 'required',
            'price' => 'required|numeric',
        ];
    }

    public function messages(): array
    {
        return [
            'product_head_id.required' => 'Product field is required.',
            'country_id.required' => 'Country field is required.',
        ];
    }
}
