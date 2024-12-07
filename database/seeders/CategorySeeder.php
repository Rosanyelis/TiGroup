<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Category::create(['name' => 'Hosting']);
        Category::create(['name' => 'Tiendas Online']);
        Category::create(['name' => 'Servidores VPS']);
        Category::create(['name' => 'Soporte TI']);
        Category::create(['name' => 'Redes Sociales']);
        Category::create(['name' => 'Desarrollo Web']);
        Category::create(['name' => 'Hardware']);
        Category::create(['name' => 'Redes']);
        Category::create(['name' => 'Oficina']);
    }
}
