<?php

namespace App\Http\Requests\API\Admin\Websites;

use App\Http\Requests\JsonFormRequest;

class UpdateWebsiteRequest extends JsonFormRequest
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
            'title'     => [
                'required',
                'unique:websites,title,' . $this->id,
            ],
            'domain'    => [
                'required',
                'unique:websites,domain,' . $this->id,
            ],
            'email' => [
                'nullable',
                'email',
            ],
            'logo'    => [
                'nullable',
                'image',
                'max:100',

            ],
            'phone' => [
                'required',
            ],
            'status' => [
                'required',
            ],
            'order' => [
                'required',
                'numeric'
            ],
        ];
    }
}
