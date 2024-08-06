<?php

namespace App\Http\Requests\Masters\Authorizations\Permission;

use Illuminate\Foundation\Http\FormRequest;

class UpdatePermissionRequest extends FormRequest
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
            'name' => 'required|string|min:3|max:255|unique:permissions,name,' . $this->permission->id,
            'create' => 'nullable|boolean',
            'read' => 'nullable|boolean',
            'update' => 'nullable|boolean',
            'delete' => 'nullable|boolean',
        ];
    }
}
