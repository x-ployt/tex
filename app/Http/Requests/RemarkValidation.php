<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\Validator as ValidationValidator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class RemarkValidation extends FormRequest
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
                'remarks' => 'required|string|unique:remarks,remarks,',
                'type' => 'required|string',
            ];
        } elseif ($this->method() === 'PUT') {
            return [
                'remarks' => ['required', 'string', 'max:50', Rule::unique('remarks')->ignore($this->remark->id)],
                'type' => 'required|string',
            ];
        }
    }

    protected function failedValidation(ValidationValidator $validator)
    {
        if ($this->method() === 'POST') {
            $validator->errors()->add(
                'addRemark',
                'Add erorr'
            );
        } elseif ($this->method() === 'PUT') {
            $validator->errors()->add(
                'updateRemark',
                $this->remark->id
            );
        }
    }
}
