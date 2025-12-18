<?php

namespace App\Http\Requests\Technicel;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class TechnicelCommissionRequest extends FormRequest
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
        $required = $this->isMethod('POST') ? 'required' : 'sometimes';
        return [
            'owner_id' => ['required', 'exists:owners,id'],
            'technical_id' => ['required', 'exists:technicals,technical_id'],
            'commission_value' => [$required, 'numeric', 'min:0'],
            'commission_type' => [$required, 'string', 'max:2'],
        ];
    }

    public function messages(): array
    {
        return [
            'owner_id.required' => 'O identificador do emitente é obrigatório!',
            'owner_id.exists' => 'O identificador do emitente é inválido!',

            'technical_id.required' => 'O identificador do técnico é obrigatório!',
            'technical_id.exists' => 'O identificador do técnico é inválido!',

            'commission_value.required' => 'O valor da comissão é obrigatório!',
            'commission_value.numeric' => 'O valor da comissão precisa estar em um formato válido!',
            'commission_value.min' => 'O valor da comissão não pode ser menor que zero!',

            'commission_type.required' => 'O tipo de comissão é obrigatório!',
            'commission_type.string' => 'O tipo de comissão precisa estar em um formato válido!',
            'commission_type.max' => 'O tipo de comissão passou do tamanho permetido!',
        ];
    }
}
