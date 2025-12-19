<?php

namespace App\Http\Requests\Customer\Config;

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
            'default_type' => ['sometimes', 'max:1', 'string'],
            'trande_name_null' => ['sometimes'],
            'phone_null' => ['sometimes'],
            'address_null' => ['sometimes'],
            'number_address_null' => ['sometimes'],
        ];
    }

    public function messages()
    {
        return [
            'owner_id.required' => 'O identificador do emitente é obrigatório!',
            'owner_id.exists' => 'O identificador do emitente é inválido!',

            'default_type.max' => ['O tipo padrão do cadastro precisa estar em um formáto válido!'],
            'default_type.string' => ['O tipo padrão do cadastro precisa estar em um formáto válido!'],

        ];
    }
}
