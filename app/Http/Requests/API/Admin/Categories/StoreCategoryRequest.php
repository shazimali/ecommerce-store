<?php

namespace App\Http\Requests\API\Admin\Categories;

use App\Http\Requests\JsonFormRequest;


class StoreCategoryRequest extends  JsonFormRequest
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
            'title' => 'required|unique:categories,title',
            'slug' => 'required|unique:categories,slug',
            'image' => 'required|image|max:500',
            'websites' => 'required|array'
        ];
    }
}
