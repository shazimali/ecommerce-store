<?php

namespace App\Http\Requests\API\Admin\Badges;

use App\Http\Requests\JsonFormRequest;

class UpdateBadgeRequest extends JsonFormRequest
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
            'title' => 'required|string|max:255|unique:badges,title,' . $this->route('id'),
            'image' => 'nullable|image|max:1024',
            'status' => 'required|string|in:ACTIVE,INACTIVE',
            'sub_categories' => 'nullable|array',
            'sub_categories.*' => 'exists:sub_categories,id',
        ];
    }
}
