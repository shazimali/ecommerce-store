<?php

namespace App\Http\Requests\API\Admin\Users;

use App\Http\Requests\JsonFormRequest;

class UpdateUserRequest extends JsonFormRequest
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
            'name' => 'required',
            'email'     => [
                'required',
                'unique:users,email,' . $this->id,
                'max:50',
            ],
            'password' => 'nullable|confirmed',
            'roles'    => [
                'required',
                'array',
            ],
        ];
    }
}
