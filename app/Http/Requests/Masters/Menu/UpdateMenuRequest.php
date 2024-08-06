<?php

namespace App\Http\Requests\Masters\Menu;

use Illuminate\Foundation\Http\FormRequest;

class UpdateMenuRequest extends FormRequest
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
            'title' => 'nullable|string|max:255',
            'name' => 'required|string|min:3|max:255|unique:menus,name,' . $this->menu->id,
            'icon' => 'required_if:parent_id,null|prohibited_unless:parent_id,null',
            'parent_id' => 'nullable|exists:menus,id'
        ];
    }
}
