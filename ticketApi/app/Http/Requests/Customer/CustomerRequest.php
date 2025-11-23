<?php

namespace App\Http\Requests\Customer;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

class CustomerRequest extends FormRequest
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
            'cnpj_cpf' => $this->cnpj_cpf ? formatCPFCNPJ($this->cnpj_cpf) : null
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
            'owner_id' => ['required', 'exists:App\Models\Owner,id'],
            'company_name' => [$required, 'max:120'],
            'trade_name' => [$required, 'max:120'],
            'cnpj_cpf' => [
                $this->isMethod('post') ? 'required' : 'prohibited',
                'max:14',
                Rule::unique('customers', 'cnpj_cpf')->ignore($this->customer),
            ],
            'phone' => [$required, 'string', 'max:24'],
            'cep' => [$required, 'string', 'max:8'],
            'address' => [$required, 'string', 'max:60'],
            'number' => [$required, 'string', 'max:16'],
        ];
    }

    public function messages()
    {
        return [
            'owner_id.required' => 'O identificador do emitente é obrigatório!',
            'owner_id.exists' => 'O identificador do emitente é inválido!',

            'company_name.required' => 'A razão social é obrigatório!',
            'company_name.max' => 'A razão social precisa ter no máximo 120 caracteres!',
            
            'trade_name.required' => 'O nome fantasia é obrigatório!',
            'trade_name.max' => 'O nome fantasia precisa ter no máximo 120 caracteres!',
            
            'cnpj_cpf.required' => 'O CPF/CNPJ é obrigatório!',
            'cnpj_cpf.string' => 'O CPF/CNPJ precisa ser um formato válido!',
            'cnpj_cpf.max' => 'O CPF/CNPJ precisa ter no máximo 14 caracteres!',
            'cnpj_cpf.unique' => 'Esse CPF/CNPJ já está cadastrado!',
            
            'phone.required' => 'O telefone da empresa é obrigatório!',
            'phone.string' => 'O telefone da empresa precisa estar em um formato válido!',
            'phone.max' => 'O telefone da empresa precisa ter no máximo 24 caracteres!',

            'cep.required' => 'O CEP da empresa é obrigatório!',
            'cep.string' => 'O CEP da empresa precisa estar em um formato válido!',
            'cep.max' => 'O CEP precisa ter no máximo 8 caracteres!',

            'address.required' => 'O endereço fantasia é obrigatório!',
            'address.string' => 'O endereço precisa estar em um formato válido!',
            'address.max' => 'O endereço ter no máximo 60 caracteres!',

            'number.required' => 'O número do enedereço é obrigatório!',
            'number.string' => 'O número do enedereço precisa estar em um formato válido!',
            'number.max' => 'O número do enedereço ter no máximo 16 caracteres!',
            
        ];
    }
}
