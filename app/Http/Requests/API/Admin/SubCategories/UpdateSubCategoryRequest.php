<?php

namespace App\Http\Requests\API\Admin\SubCategories;

use Illuminate\Foundation\Http\FormRequest;

class UpdateSubCategoryRequest extends FormRequest
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
            'title' => 'required|unique:sub_categories,title,' . $this->id,
            'slug' => 'required|unique:sub_categories,slug,' . $this->id,
            'image' => 'nullable|image|max:500',
            'order' => 'required|numeric'

        ];
    }
}
