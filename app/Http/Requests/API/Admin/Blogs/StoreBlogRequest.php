<?php

namespace App\Http\Requests\API\Admin\Blogs;

use App\Http\Requests\JsonFormRequest;
use Illuminate\Foundation\Http\FormRequest;

class StoreBlogRequest extends JsonFormRequest
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
            'title' => [
                'required',
                'unique:blogs,title'
            ],
            'slug' => [
                'required',
                'unique:blogs,slug'
            ],
            'image' => [
                'required'
            ],
            'description' => [
                'required'
            ],
            'seo_title' => 'required',
            'seo_desc' => 'required',
            'status' => 'required',
            // 'countries' => 'required|array'
        ];
    }
}
