<?php

namespace App\Http\Requests\API\Admin\Permissions;

use App\Http\Requests\JsonFormRequest;
use Illuminate\Foundation\Http\FormRequest;

class StorePermissionRequest extends JsonFormRequest
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
            'name' => 'required|unique:permissions,name',
            'key' => 'required|unique:permissions,key',
        ];
    }
}
