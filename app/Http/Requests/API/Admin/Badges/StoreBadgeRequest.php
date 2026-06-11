<?php

namespace App\Http\Requests\API\Admin\Badges;

use App\Http\Requests\JsonFormRequest;

class StoreBadgeRequest extends JsonFormRequest
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
            'title' => 'required|string|unique:badges,title|max:255',
            'image' => 'required|image|max:1024',
            'status' => 'required|string|in:ACTIVE,INACTIVE',
            'sub_categories' => 'nullable|array',
            'sub_categories.*' => 'exists:sub_categories,id',
        ];
    }
}
