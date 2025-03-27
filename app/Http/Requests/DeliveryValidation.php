<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class DeliveryValidation extends FormRequest
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
    public function rules()
    {
        $routeName = $this->route()->getName();

        if ($routeName === 'order.markDelivered') {
            return [
                'delivery_photos'   => 'required|array|min:1',
                'delivery_photos.*' => 'required|file|mimes:jpg,jpeg,png|max:51200',
            ];
        } elseif ($routeName === 'order.markRTS') {
            return [
                'reason' => 'required|string',
            ];
        } elseif ($routeName === 'order.markReschedule') {
            return [
                'reason' => 'required|string',
            ];
        }

        return [];
    }
}
