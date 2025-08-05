<?php

namespace App\Http\Requests\API\Admin\Collections;

use Illuminate\Foundation\Http\FormRequest;

class UpdateCollectionRequest extends FormRequest
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
            'title' => 'required|unique:collections,title,' . $this->id,
            'slug' => 'required|unique:collections,slug,' . $this->id,
            'status' => 'required',
            'order' => 'required|numeric',
            'position' => 'required',
            'image' => 'nullable|image|max:500',
            'mob_image' => 'nullable|image|max:500',
            // 'countries'    => [
            //     'required',
            //     'array',
            // ],
            'websites'    => [
                'required',
                'array',
            ],
            'products'    => [
                'required',
                'array',
            ],
        ];
    }
}
