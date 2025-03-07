<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\Validator as ValidationValidator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class AccountValidation extends FormRequest
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
                'name' => 'required|string|max:50',
                'username' => 'required|string|unique:users,username,',
                'email' => 'required|email|unique:users,email,',
                'contact_number' => 'required|string|max:11',
                'branch_id' => 'required|string|max:50',
                'role_id' => 'required|string|max:50',
            ];
        } elseif ($this->method() === 'PUT') {
            return [
                'name' => 'required|string|max:50',
                'username' => ['required', 'string', 'max:50', Rule::unique('users')->ignore($this->user->id)],
                'email' => ['required', 'email', 'max:50', Rule::unique('users')->ignore($this->user->id)],
                'contact_number' => 'required|string|max:11',
                'branch_id' => 'required|string|max:50',
                'role_id' => 'required|string|max:50',
            ];
        }
    }

    protected function failedValidation(ValidationValidator $validator)
    {
        if ($this->method() === 'POST') {
            $validator->errors()->add(
                'addAccount',
                'Add erorr'
            );
        } elseif ($this->method() === 'PUT') {
            $validator->errors()->add(
                'updateAccount',
                $this->user->id
            );
        }
    }
}
