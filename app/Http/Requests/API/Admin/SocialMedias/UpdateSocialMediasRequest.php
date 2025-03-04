<?php

namespace App\Http\Requests\API\Admin\SocialMedias;

use Illuminate\Foundation\Http\FormRequest;

class UpdateSocialMediasRequest extends FormRequest
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
            'title' => 'required',
            'class' => 'required',
            'url' => 'required',
        ];
    }
}
