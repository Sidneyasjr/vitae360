<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

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
            'tax_id' => ['required', 'string', 'size:14', 'unique:companies,tax_id'],
            'company_name' => ['required', 'string', 'max:255'],
            'trade_name' => ['required', 'string', 'max:255'],
            'contact_person' => ['required', 'string', 'max:255'],
            'position' => ['required', 'string', 'max:255'],
            'phone' => ['required', 'string', 'max:20'],
            'phone2' => ['nullable', 'string', 'max:20'],
            'contact_email' => ['required', 'email', 'max:255'],
            'billing_email' => ['nullable', 'email', 'max:255'],
            'zip_code' => ['required', 'string', 'size:8'],
            'address' => ['required', 'string', 'max:255'],
            'number' => ['required', 'string', 'max:20'],
            'neighborhood' => ['required', 'string', 'max:255'],
            'state' => ['required', 'string', 'size:2'],
            'city' => ['required', 'string', 'max:255'],
            'lead' => ['required', 'string', 'max:255'],
            'interest' => ['required', 'string', 'max:255'],
            'segment' => ['required', 'string', 'max:255'],
            'legal_representative_name' => ['nullable', 'string', 'max:255'],
            'legal_representative_tax_id' => ['nullable', 'string', 'size:11'],
            'legal_representative_email' => ['nullable', 'email', 'max:255'],
        ];
    }

    public function messages(): array
    {
        return [
            'tax_id.required' => 'O CNPJ é obrigatório',
            'tax_id.size' => 'O CNPJ deve ter 14 caracteres',
            'tax_id.unique' => 'Este CNPJ já está cadastrado',
            'company_name.required' => 'A razão social é obrigatória',
            'trade_name.required' => 'O nome fantasia é obrigatório',
            'contact_person.required' => 'O contato de relacionamento é obrigatório',
            'position.required' => 'O cargo é obrigatório',
            'phone.required' => 'O telefone é obrigatório',
            'contact_email.required' => 'O e-mail de relacionamento é obrigatório',
            'contact_email.email' => 'O e-mail de relacionamento deve ser válido',
            'zip_code.required' => 'O CEP é obrigatório',
            'zip_code.size' => 'O CEP deve ter 8 caracteres',
            'address.required' => 'O endereço é obrigatório',
            'number.required' => 'O número é obrigatório',
            'neighborhood.required' => 'O bairro é obrigatório',
            'state.required' => 'O estado é obrigatório',
            'state.size' => 'O estado deve ter 2 caracteres',
            'city.required' => 'A cidade é obrigatória',
            'lead.required' => 'O lead é obrigatório',
            'interest.required' => 'O interesse é obrigatório',
            'segment.required' => 'O segmento é obrigatório',
            'legal_representative_tax_id.size' => 'O CPF deve ter 11 caracteres',
            'legal_representative_email.email' => 'O e-mail do representante legal deve ser válido',
        ];
    }
}
