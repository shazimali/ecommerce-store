<?php

namespace App\Http\Requests\API\Admin\Purchases;

use App\Http\Requests\JsonFormRequest;
use Illuminate\Foundation\Http\FormRequest;

class StorePurchaseRequest extends JsonFormRequest
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
            'invoice_id' => 'required',
            'invoice_date' => 'required|date',
            'supplier_id' => 'required',
            'total_qty' => 'required',
            'total_price' => 'required',
            'purchase_detail' => 'required|array'
        ];
    }

    public function messages(): array
    {
        return [
            'supplier_id.required' => 'Supplier field is required.'
        ];
    }
}
