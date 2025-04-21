<?php

namespace App\Http\Requests\API\Admin\Pages;

use App\Http\Requests\JsonFormRequest;
use Illuminate\Foundation\Http\FormRequest;

class StorePagesRequest extends JsonFormRequest
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
            'slug' => 'required',
            'content' => 'required',
            'status' => 'required',
            'seo_title' => 'required',
            'seo_description' => 'required',
            'position' => 'required',
        ];
    }
}
