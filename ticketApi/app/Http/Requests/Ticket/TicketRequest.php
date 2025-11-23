<?php

namespace App\Http\Requests\Ticket;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class TicketRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return Auth::check();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'owner_id' => ['required', 'exists:App\Models\Owner,id'],
            'customer_id' => ['sometimes'],
            'title' => ['sometimes', 'string', 'max:60'],
            'description' => ['sometimes', 'string'],
            'priority' => ['sometimes', 'string'],
            'location' => ['sometimes', 'string', 'max:40'],
            'location_value' => ['sometimes', 'numeric'],
            'increase_value' => ['sometimes', 'numeric'],
            'increase_tpye' => ['sometimes', 'string'],
            'discount_value' => ['sometimes', 'numeric'],
            'discount_type' => ['sometimes', 'string'],
            'base_value' => ['sometimes', 'numeric'],            

            'date_paid' => ['sometimes', 'date'],
            'status' => ['sometimes'],

            // Para alterações e finalização
            'ticket_id' => ['sometimes'],
            'ticket_code' => ['sometimes'],
            'operation' => ['sometimes'],
            'amount_paid' => ['sometimes', 'numeric'],
            'pay_ment_form_id' => ['sometimes']

        ];
    }
}
