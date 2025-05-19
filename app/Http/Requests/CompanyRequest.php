<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class CompanyRequest extends FormRequest
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
    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'max:255'],
            'cnpj' => [
                'required',
                'string',
                'size:18',
                Rule::unique('companies', 'cnpj')->ignore(optional(request()->route('company'))->id)
            ],
            'email' => ['required', 'email', 'max:255'],
        ];
    }

    public function messages(): array
    {
        return [
            'name.required' => 'O nome é obrigatório',
            'cnpj.required' => 'O CNPJ é obrigatório',
            'cnpj.size' => 'O CNPJ deve ter 14 caracteres',
            'cnpj.unique' => 'Este CNPJ já está cadastrado',
            'email.required' => 'O e-mail é obrigatório',
            'email.email' => 'O e-mail deve ser válido',
        ];
    }
}
