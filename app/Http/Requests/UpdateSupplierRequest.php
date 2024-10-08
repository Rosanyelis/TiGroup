<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateSupplierRequest extends FormRequest
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
            'name' => ['required', 'string', 'max:255',],
            'email' => ['required', 'email'],
            'rut' => ['required'],
        ];
    }

    public function messages(): array
    {
        return [
            'business_name.required' => 'La Razon Social o Nombre es requerido',
            'name.required' => 'El Nombre del Proveedor es requerido',
            'email.unique' => 'El Correo ya existe',
            'email.required' => 'El Correo es requerido',
            'email.email' => 'El Correo debe ser válido',
            'rut.unique' => 'El Rut ya existe',
            'rut.required' => 'El Rut es requerido',
        ];
    }
}
