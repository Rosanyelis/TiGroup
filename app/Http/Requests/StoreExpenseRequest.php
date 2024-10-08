<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreExpenseRequest extends FormRequest
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
            'name' => ['required'],
            'note' => ['required'],
            'amount' => ['required'],
        ];
    }

    public function messages(): array
    {
        return [
            'name.required' => 'El Tipo de Gasto es obligatorio',
            'note.required' => 'La descripción es obligatoria',
            'amount.required' => 'El monto es obligatorio',
        ];
    }
}
