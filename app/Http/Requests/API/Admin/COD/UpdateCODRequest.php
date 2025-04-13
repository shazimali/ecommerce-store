<?php

namespace App\Http\Requests\API\Admin\COD;

use App\Http\Requests\JsonFormRequest;
use Illuminate\Foundation\Http\FormRequest;

class UpdateCODRequest extends JsonFormRequest
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
            'title' => 'required',
            'api_url' => 'required',
            'api_key' => 'required',
            'api_password' => 'required',
            'status' => 'required',
        ];
    }
}
