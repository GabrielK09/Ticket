<?php

namespace App\Http\Requests\PayMentForm;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class PayMentFormRequest extends FormRequest
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
            'pay_ment_form' => ['required', 'string', 'max:60'],
            'type' => ['required', 'string', 'max:12'],
        ];
    }
}
