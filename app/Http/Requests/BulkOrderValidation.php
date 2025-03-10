<?php

namespace App\Http\Requests;

use App\Models\Branch;
use App\Models\User;
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
            'orders.*.customer_contact_number' => 'required|string|max:11;',
            'orders.*.order_amount' => 'required|string',
            'orders.*.order_mop' => 'required|string',
            
            // Validate branch_name and check if it exists in the branches table
            'orders.*.branch_name' => [
                'required',
                function ($attribute, $value, $fail) {
                    if (!Branch::where('branch_name', $value)->exists()) {
                        $fail("The branch name '{$value}' does not exist.");
                    }
                },
            ],

            // Validate rider_name and check if it exists in the users table
            'orders.*.rider_name' => [
                'required',
                function ($attribute, $value, $fail) {
                    if (!User::where('name', $value)->exists()) {
                        $fail("The rider name '{$value}' does not exist.");
                    }
                },
            ],

            'orders.*.file_paths' => 'nullable|json',
            'orders.*.order_status' => 'required|string',
        ];
    }

}
