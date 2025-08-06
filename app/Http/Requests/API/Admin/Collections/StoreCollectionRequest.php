<?php

namespace App\Http\Requests\API\Admin\Collections;

use App\Http\Requests\JsonFormRequest;

class StoreCollectionRequest extends JsonFormRequest
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
            'title' => 'required|unique:collections,title',
            'slug' => 'required|unique:collections,slug',
            'status' => 'required',
            'order' => 'required|numeric',
            'position' => 'required',
            'image' => 'required|image|max:500',
            'mob_image' => 'required|image|max:500',
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
