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
        return [
            'owner_id' => ['required', 'exists:owners,id'],
            'technical_id' => ['required', 'exists:technicals,technical_id'],
            'technical_name' => ['required', 'string', 'max:120'],
            'commission_value' => ['required', 'numeric', 'min:0.1'],
            'commission_type' => ['required', 'string', 'max:2'],
        ];
    }

    public function messages(): array
    {
        return [
            'owner_id.required' => 'O identificador do emitente é obrigatório!',
            'owner_id.exists' => 'O identificador do emitente é inválido!',

            'technical_id.required' => 'O identificador do técnico é obrigatório!',
            'technical_id.exists' => 'O identificador do técnico é inválido!',

            'technical_name.required' => 'O nome do técnico é obrigatório!',
            'technical_name.string' => 'O nome do técnico precisa estar em um formato válido!',
            'technical_name.max' => 'O nome do técnico passou do tamanho permetido!',

            'commission_value.required' => 'O valor da comissão é obrigatório!',
            'commission_value.numeric' => 'O valor da comissão precisa estar em um formato válido!',
            'commission_value.min' => 'O valor da comissão precisa ser maior que zero!',

            'commission_type.required' => 'O tipo de comissão é obrigatório!',
            'commission_type.string' => 'O tipo de comissão precisa estar em um formato válido!',
            'commission_type.max' => 'O tipo de comissão passou do tamanho permetido!',
        ];
    }
}
