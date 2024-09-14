<?php

namespace Database\Seeders;

use App\Models\Rols;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class RolsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Rols::create(['name' => 'Desarrollador']);
        Rols::create(['name' => 'Administrador']);
        Rols::create(['name' => 'Operador']);
    }
}
