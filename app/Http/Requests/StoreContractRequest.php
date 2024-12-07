<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreContractRequest extends FormRequest
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
            'customer_id' => 'required|',
            'type' => 'required',
            'type_contract' => 'required',
            'start_date' => 'required',
            'confirm_invoice' => 'required',
            'status' => 'required',
        ];
    }

    public function messages()
    {
        return [
            'customer_id.required' => 'El campo cliente es obligatorio.',
            'type.required' => 'El campo tipo de contrato es obligatorio.',
            'type_contract.required' => 'El campo tipo de contrato es obligatorio.',
            'start_date.required' => 'El campo fecha de inicio es obligatorio.',
            'confirm_invoice.required' => 'El campo confirmar factura es obligatorio.',
            'status.required' => 'El campo estado es obligatorio.',
        ];
    }
}
