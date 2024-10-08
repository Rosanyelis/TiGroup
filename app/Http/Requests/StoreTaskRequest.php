<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreTaskRequest extends FormRequest
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
            'task' => 'required',
            'fecha_inicio' => 'required',
            'fecha_fin' => 'required',
        ];
    }

    public function messages(): array
    {
        return [
            'task.required' => 'El campo Tarea es obligatorio',
            'fecha_inicio.required' => 'El campo Fecha Inicio es obligatorio',
            'fecha_fin.required' => 'El campo Fecha Fin es obligatorio',
        ];
    }
}
