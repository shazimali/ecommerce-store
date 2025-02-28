<?php

namespace App\Http\Requests\API\Admin\Categories;

use Illuminate\Foundation\Http\FormRequest;

class UpdateCategoryRequest extends FormRequest
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
            'title' => 'required|unique:categories,title,' . $this->id,
            'slug' => 'required|unique:categories,slug,' . $this->id,
            'websites' => 'required|array',
            'order' => 'required|numeric',
            'image' => 'nullable|image|max:500',

        ];
    }
}
