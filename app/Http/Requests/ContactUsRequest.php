<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ContactUsRequest extends FormRequest
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
            'subject' => 'required',
            'message' => 'required',
            'attachment' => [
                'nullable',
                'file', // Explicitly check for a valid file upload
                'mimes:pdf,doc,docx,png,jpg,jpeg',
                'max:500'
            ]

        ];
    }
}
