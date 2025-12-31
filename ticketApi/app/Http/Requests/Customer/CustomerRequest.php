<?php

namespace App\Http\Requests\Customer;

use App\Enum\MessagesRequest\CommonMessagesRequest;
use App\Enum\MessagesRequest\Customer\CustomerMessagesRequest;
use App\Services\Customer\Config\CustomerConfigService;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\Rule;
class CustomerRequest extends FormRequest
{
    public function __construct(
        protected CustomerConfigService $customerConfigService   
    ){}
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
            'cep' => $this->cep ? formatCEP($this->cep) : null,
            'phone' => $this->phone ? formatPhone($this->phone) : null
        ]);
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        $config = $this->customerConfigService->show($this->owner_id);
        Log::debug($this->phone);

        return [
            'owner_id' => ['required', 'exists:App\Models\Owner,id'],
            'company_name' => ['required', 'string', 'max:120'],
            'trade_name' => [$config['trade_name_null'] ? 'sometimes' : 'required' , 'string', 'max:120'],
            'cnpj_cpf' => [
                $this->isMethod('post') ? 'required' : 'prohibited',
                'max:14',
                Rule::unique('customers', 'cnpj_cpf')->ignore($this->customer),
            ],
            'phone' => [$config['phone_null'] ? 'sometimes' : ['required' , 'string', 'max:24']],
            'cep' => ['required', 'string', 'max:9'],
            'address' => [$config['address_null'] ? 'sometimes' : ['required' , 'string', 'max:60']],
            'number' => [$config['number_address_null'] ? 'sometimes' : ['required' , 'string', 'max:16']],
        ];
    }

    public function messages()
    {
        return [
            'owner_id.required' => CommonMessagesRequest::OWNER_ID->value,
            'owner_id.exists' => CommonMessagesRequest::OWNER_ID->value,

            'company_name.required' => CustomerMessagesRequest::COMPAYN_NAME_REQUIRED->value,
            'company_name.string' => CustomerMessagesRequest::COMPAYN_NAME_INVALID_FORMAT->value,
            'company_name.max' => CustomerMessagesRequest::COMPAYN_NAME_MAX->value,

            'trade_name.required' => CustomerMessagesRequest::TRADE_NAME_REQUIRED->value,
            'trade_name.string' => CustomerMessagesRequest::TRADE_NAME_INVALID_FORMAT->value,
            'trade_name.max' => CustomerMessagesRequest::TRADE_NAME_MAX->value,
            
            'cnpj_cpf.required' => CommonMessagesRequest::CNPJ_CPF_REQUIRED->value,
            'cnpj_cpf.string' => CommonMessagesRequest::CNPJ_CPF_REQUIRED->value,
            'cnpj_cpf.max' => CommonMessagesRequest::CNPJ_CPF_MAX->value,
            'cnpj_cpf.unique' => CommonMessagesRequest::CNPJ_CPF_UNIQUE->value,
            'cnpj_cpf.prohibited' => CommonMessagesRequest::CNPJ_CPF_PROHIBITED->value,
            
            'phone.required' => CustomerMessagesRequest::PHONE_REQUIRED->value,
            'phone.string' => CustomerMessagesRequest::PHONE_INVALID_FORMAT->value,
            'phone.max' => CustomerMessagesRequest::PHONE_MAX->value,

            'cep.required' => CustomerMessagesRequest::CEP_REQUIRED->value,
            'cep.string' => CustomerMessagesRequest::CEP_INVALID_FORMAT->value,
            'cep.max' => CustomerMessagesRequest::CEP_MAX->value,

            'address.required' => CustomerMessagesRequest::ADDRESS_REQUIRED->value,
            'address.string' => CustomerMessagesRequest::ADDRESS_INVALID_FORMAT->value,
            'address.max' => CustomerMessagesRequest::ADDRESS_MAX->value,

            'number.required' => CustomerMessagesRequest::NUMBER_ADDRESS_REQUIRED->value,
            'number.string' => CustomerMessagesRequest::NUMBER_ADDRESS_INVALID_FORMAT->value,
            'number.max' => CustomerMessagesRequest::NUMBER_ADDRESS_MAX->value,
            
        ];
    }
}
