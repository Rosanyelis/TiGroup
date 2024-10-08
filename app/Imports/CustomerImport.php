<?php

namespace App\Imports;

use App\Models\Customer;
use Illuminate\Support\Str;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class CustomerImport implements ToModel, WithHeadingRow
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        return new Customer([
            'business_name'     => Str::upper($row['razon_social']),
            'rut'               => $row['rut'],
            'name'              => $row['contacto'],
            'giro'              => $row['giro'],
            'email'             => $row['correo'],
            'email_secondary'   => $row['correo_secundario'],
            'phone'             => $row['telefono'],
            'comuna'            => $row['comuna'],
            'address'           => $row['direccion'],
        ]);
    }
}
