<?php

namespace Database\Seeders;

use App\Models\WorkSpace;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class WorkSpaceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        WorkSpace::create([
            'user_id' => 1,
            'title' => 'TiGroup',
            'description' => 'panel de gestion de clientes',
            'status' => 'Activo'
        ]);
    }
}
