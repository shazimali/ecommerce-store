<?php

namespace App\Http\Requests\API\Admin\Banners;

use Illuminate\Foundation\Http\FormRequest;

class UpdateBannerRequest extends FormRequest
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
            'title' => 'required|unique:banners,title,' . $this->id,
            'image' => 'nullable|image|max:500',
            'mob_image' => 'nullable|image|max:500',
            'order' => 'required',
            'btn_link' => 'required|url'
        ];
    }
}
