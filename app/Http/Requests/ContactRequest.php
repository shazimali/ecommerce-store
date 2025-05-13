<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ContactRequest extends FormRequest
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
            'first_name' => 'required',
            'last_name' => 'required',
            'email_address' => 'required|email',
            'email_address_confirmation' => 'required|email',
            'contact_number' => 'required',
            'type' => 'required',
            'product_code' => 'required',
            'message' => 'required',
            'attachment' => [
                'required',
                'file', // Explicitly check for a valid file upload
                'mimes:pdf,doc,docx',
                'max:500' // 500KB limit (adjust if you meant 500MB)
            ]

        ];
    }
}
