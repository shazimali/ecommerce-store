<?php

namespace App\Http\Requests\API\Admin\SubCategories;

use App\Http\Requests\JsonFormRequest;
use Illuminate\Foundation\Http\FormRequest;

class StoreSubCategoryRequest extends JsonFormRequest
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
            'title' => 'required|unique:sub_categories,title',
            'slug' => 'required|unique:sub_categories,slug',
            'order' => 'required|numeric',
            'image' => 'required|image|max:500'

        ];
    }
}
