<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreCustomerRequest extends FormRequest
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
            'business_name' => ['required'],
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'unique:customers,email'],
            'rut' => ['required', 'unique:customers,rut'],
        ];
    }

    public function messages(): array
    {
        return [
            'business_name.required' => 'La Razon Social o Nombre es requerido',
            'name.required' => 'El Nombre del Cliente es requerido',
            'email.unique' => 'El Correo ya existe',
            'email.required' => 'El Correo es requerido',
            'email.email' => 'El Correo debe ser válido',
            'rut.unique' => 'El Rut ya existe',
            'rut.required' => 'El Rut es requerido',
        ];
    }
}
