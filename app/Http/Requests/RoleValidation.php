<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\Validator as ValidationValidator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class RoleValidation extends FormRequest
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
        if  ($this->method() === 'POST') {
            return [
                'role_name' => 'required|string|unique:roles,role_name,',
            ];
        } elseif ($this->method() === 'PUT') {
            return [
                'role_name' => ['required', 'string', 'max:50', Rule::unique('roles')->ignore($this->role->id)],
            ];
        }
    }

    protected function failedValidation(ValidationValidator $validator)
    {
        if ($this->method() === 'POST') {
            $validator->errors()->add(
                'addRole',
                'Add erorr'
            );
        } elseif ($this->method() === 'PUT') {
            $validator->errors()->add(
                'updateRole',
                $this->role->id
            );
        }
    }
}
