<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class BulkOrderValidation extends FormRequest
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
            'orders' => 'required|array',
            'orders.*.order_no' => 'required|string|unique:orders,order_no',
            'orders.*.customer_name' => 'required|string',
            'orders.*.customer_address' => 'required|string',
            'orders.*.branch_id' => 'required|exists:branches,id',
            'orders.*.file_paths' => 'nullable|json',
            'orders.*.order_status' => 'required|string',
            
            // Validate the selected rider from the form
            'assigned_user_id' => 'required|exists:users,id', 
        ];
        
    }
}
