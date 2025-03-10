<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator as ValidationValidator;
class OrderValidation extends FormRequest
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
                'order_no' => 'required|string|unique:orders,order_no',
                'customer_name' => 'required|string',
                'customer_address' => 'required|string',
                'customer_contact_number' => 'required|string|max:11',
                'order_amount' => 'required|string',
                'order_mop' => 'required|string',
                'assigned_user_id' => 'required|exists:users,id',
                'branch_id' => 'required|exists:branches,id',
                'file_paths' => 'nullable|json',
                'order_status' => 'required|string',
                'reason' => 'nullable|string'
            ];
        } elseif ($this->method() === 'PUT') {
            return [
                'order_no' => 'required|string|unique:orders,order_no,' . $this->route('order')->id,
                'customer_name' => 'required|string',
                'customer_address' => 'required|string',
                'customer_contact_number' => 'required|string|max:11',
                'assigned_user_id' => 'required|exists:users,id',
                'branch_id' => 'required|exists:branches,id',
                'file_paths' => 'nullable|json',
                'order_status' => 'required|string',
                'reason' => 'nullable|string'
            ];
        }
    }

    protected function failedValidation(ValidationValidator $validator)
    {
        if ($this->method() === 'POST') {
            $validator->errors()->add(
                'addOrder',
                'Add erorr'
            );
        } elseif ($this->method() === 'PUT') {
            $validator->errors()->add(
                'updateOrder',
                $this->order->id
            );
        }
    }
}
