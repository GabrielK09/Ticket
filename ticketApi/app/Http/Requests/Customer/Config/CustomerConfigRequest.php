<?php

namespace App\Http\Requests\Customer\Config;

use App\Enum\MessagesRequest\CommonMessagesRequest;
use App\Enum\MessagesRequest\Customer\CustomerConfigRequest as CustomerCustomerConfigRequest;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class CustomerConfigRequest extends FormRequest
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
            'default_type' => ['sometimes', 'max:1', 'string', 'in:F,J'],
            'trade_name_null' => ['sometimes'],
            'phone_null' => ['sometimes'],
            'address_null' => ['sometimes'],
            'number_address_null' => ['sometimes'],
        ];
    }

    public function messages()
    {
        return [
            'owner_id.required' => CommonMessagesRequest::OWNER_ID,
            'owner_id.exists' => CommonMessagesRequest::OWNER_ID,

            'default_type.max' => CustomerCustomerConfigRequest::DEFAULT_TYPE_MAX,
            'default_type.string' => CustomerCustomerConfigRequest::DEFAULT_TYPE_INVALID_FORMAT,
            'default_type.in' => CustomerCustomerConfigRequest::DEFAULT_TYPE_IN,

        ];
    }
}
