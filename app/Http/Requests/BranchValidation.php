<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\Validator as ValidationValidator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class BranchValidation extends FormRequest
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
                'branch_name' => 'required|string|unique:branches,branch_name,',
                'branch_address' => 'required|string|unique:branches,branch_address,',
            ];
        } elseif ($this->method() === 'PUT') {
            return [
                'branch_name' => ['required', 'string', 'max:50', Rule::unique('branches')->ignore($this->branch->id)],
                'branch_address' => ['required', 'string', 'max:50', Rule::unique('branches')->ignore($this->branch->id)],
            ];
        }
    }

    protected function failedValidation(ValidationValidator $validator)
    {
        if ($this->method() === 'POST') {
            $validator->errors()->add(
                'addBranch',
                'Add erorr'
            );
        } elseif ($this->method() === 'PUT') {
            $validator->errors()->add(
                'updateBranch',
                $this->branch->id
            );
        }
    }
}
