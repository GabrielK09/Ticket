<?php

namespace App\Http\Requests\Owner;

use App\Enum\MessagesRequest\CommonMessagesRequest;
use App\Enum\MessagesRequest\Owner\OwnerMessagesRequest;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

class OwnerRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return Auth::check();
    }

    protected function prepareForValidation()
    {
        $this->merge([
            'cnpj_cpf' => $this->cnpj_cpf ? formatCPFCNPJ($this->cnpj_cpf) : null,
            'cep' => formatCEP($this->cep)
        ]);
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        $required = $this->isMethod('post') ? 'required' : 'sometimes';
        
        return [
            'user_id' => ['required'],
            'company_name' => [$required, 'max:120'],
            'trade_name' => [$required, 'max:120'],
            'cnpj_cpf' => [
                $this->isMethod('post') ? 'required' : 'prohibited',
                'max:14',
                Rule::unique('owners', 'cnpj_cpf')->ignore($this->owner),
            ],
            
            'phone' => [$required, 'string', 'max:24',],
            'cep' => [$required, 'string', 'max:8', ],
            'address' => [$required, 'string', 'max:60'],
            'number' => [$required, 'string', 'max:16'],
            'cnae' => [$required, 'string', 'max:14'],
            'activity' => [$required, 'string', 'max:120'],
        ];
    }

    public function messages()
    {
        return [
            'user_id.required' =>CommonMessagesRequest::USER_ID->value,

            'company_name.required' => OwnerMessagesRequest::COMPAYN_NAME_REQUIRED->value,
            'company_name.string' => OwnerMessagesRequest::COMPAYN_NAME_INVALID_FORMAT->value,
            'company_name.max' => OwnerMessagesRequest::COMPAYN_NAME_MAX->value,

            'trade_name.required' => OwnerMessagesRequest::TRADE_NAME_REQUIRED->value,
            'trade_name.string' => OwnerMessagesRequest::TRADE_NAME_INVALID_FORMAT->value,
            'trade_name.max' => OwnerMessagesRequest::TRADE_NAME_MAX->value,
            
            'cnpj_cpf.required' => CommonMessagesRequest::CNPJ_CPF_REQUIRED->value,
            'cnpj_cpf.string' => CommonMessagesRequest::CNPJ_CPF_REQUIRED->value,
            'cnpj_cpf.max' => CommonMessagesRequest::CNPJ_CPF_INVALID_MAX->value,
            'cnpj_cpf.unique' => CommonMessagesRequest::CNPJ_CPF_UNIQUE->value,
            'cnpj_cpf.prohibited' => CommonMessagesRequest::CNPJ_CPF_PROHIBITED->value,
            
            'phone.required' => OwnerMessagesRequest::PHONE_REQUIRED->value,
            'phone.string' => OwnerMessagesRequest::PHONE_INVALID_FORMAT->value,
            'phone.max' => OwnerMessagesRequest::PHONE_MAX->value,

            'cep.required' => OwnerMessagesRequest::CEP_REQUIRED->value,
            'cep.string' => OwnerMessagesRequest::CEP_INVALID_FORMAT->value,
            'cep.max' => OwnerMessagesRequest::CEP_MAX->value,

            'address.required' => OwnerMessagesRequest::ADDRESS_REQUIRED->value,
            'address.string' => OwnerMessagesRequest::ADDRESS_INVALID_FORMAT->value,
            'address.max' => OwnerMessagesRequest::ADDRESS_MAX->value,

            'number.required' => OwnerMessagesRequest::NUMBER_ADDRESS_REQUIRED->value,
            'number.string' => OwnerMessagesRequest::NUMBER_ADDRESS_INVALID_FORMAT->value,
            'number.max' => OwnerMessagesRequest::NUMBER_ADDRESS_MAX->value,

            'cnae.required' => OwnerMessagesRequest::CNAE_REQUIRED->value,
            'cnae.string' => OwnerMessagesRequest::CNAE_INVALID_FORMAT->value,
            'cnae.max' => OwnerMessagesRequest::CNAE_MAX->value,

            'activity.required' => OwnerMessagesRequest::ACTIVITY_REQUIRED->value,
            'activity.string' => OwnerMessagesRequest::ACTIVITY_INVALID_FORMAT->value,
            'activity.max' => OwnerMessagesRequest::ACTIVITY_MAX->value,
        ];
    }
}
