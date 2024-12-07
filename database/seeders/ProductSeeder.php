<?php

namespace Database\Seeders;

use App\Models\Product;
use App\Models\Category;
use App\Models\TypeProduct;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $category_id = Category::where('name', 'Hosting')->first()->id;
        $type = TypeProduct::where('name', 'Servicios')->first()->name;
        Product::create([
            'code' => 'S-0001',
            'name' => 'Plan Pyme - Hosting Tradicional',
            'category_id' => $category_id,
            'type' => $type,
            'quantity' => null,
            'price' => 70000,
            'cost' => 70000,
            'description' => '5 GB Espacio, Correos Ilimitados, Navegación Ilimitada, SSL, CPanel',
        ]);
        Product::create([
            'code' => 'S-0002',
            'name' => 'Plan Pro - Hosting Tradicional',
            'category_id' => $category_id,
            'type' => $type,
            'quantity' => null,
            'price' => 90000,
            'cost' => 90000,
            'description' => '10 GB Espacio, Correos Ilimitados, Navegación Ilimitada, SSL, CPanel',
        ]);
        Product::create([
            'code' => 'S-0003',
            'name' => 'Plan Advanced - Hosting Tradicional',
            'category_id' => $category_id,
            'type' => $type,
            'quantity' => null,
            'price' => 120000,
            'cost' => 120000,
            'description' => '20 GB Espacio, Correos Ilimitados, Navegación Ilimitada, SSL, CPanel',
        ]);

        $category_id = Category::where('name', 'Tiendas Online')->first()->id;
        Product::create([
            'code' => 'S-0004',
            'name' => 'Plan Inicia - Tienda Online',
            'category_id' => $category_id,
            'type' => $type,
            'quantity' => null,
            'price' => 120000,
            'cost' => 120000,
            'description' => '10 GB Espacio, Correos Ilimitados, Navegación Ilimitada, SSL, CPanel',
        ]);
        Product::create([
            'code' => 'S-0005',
            'name' => 'Plan Pro - Tienda Online',
            'category_id' => $category_id,
            'type' => $type,
            'quantity' => null,
            'price' => 230000,
            'cost' => 230000,
            'description' => '20 GB Espacio, Correos Ilimitados, Navegación Ilimitada, SSL, CPanel',
        ]);
        Product::create([
            'code' => 'S-0006',
            'name' => 'Plan Advanced - Tienda Online',
            'category_id' => $category_id,
            'type' => $type,
            'quantity' => null,
            'price' => 330000,
            'cost' => 330000,
            'description' => '40 GB Espacio, Correos Ilimitados, Navegación Ilimitada, SSL, CPanel',
        ]);

        $category_id = Category::where('name', 'Servidores VPS')->first()->id;
        Product::create([
            'code' => 'S-0007',
            'name' => 'Plan Inicia - Servidores VPS',
            'category_id' => $category_id,
            'type' => $type,
            'quantity' => null,
            'price' => 900000,
            'cost' => 90000,
            'description' => '25 GB Espacio, 2 GB Ram, 2 Nucleos, Navegación Ilimitada, SSL, IP Dedicada',
        ]);
        Product::create([
            'code' => 'S-0008',
            'name' => 'Plan Pro - Servidores VPS',
            'category_id' => $category_id,
            'type' => $type,
            'quantity' => null,
            'price' => 104000,
            'cost' => 104000,
            'description' => '50 GB Espacio, 4 GB Ram, 2 Nucleos, Navegación Ilimitada, SSL, IP Dedicada',
        ]);
        Product::create([
            'code' => 'S-0009',
            'name' => 'Plan Advanced - Servidores VPS',
            'category_id' => $category_id,
            'type' => $type,
            'quantity' => null,
            'price' => 115000,
            'cost' => 115000,
            'description' => '100 GB Espacio, 8 GB Ram, 4 Nucleos, Navegación Ilimitada, SSL, IP Dedicada',
        ]);
        $category_id = Category::where('name', 'Hardware')->first()->id;
        $type = TypeProduct::where('name', 'Productos')->first()->name;
        Product::create([
            'code' => 'P-0001',
            'name' => 'Disco Duro SSD',
            'category_id' => $category_id,
            'type' => $type,
            'quantity' => 50,
            'price' => 100000,
            'cost' => 130000,
            'description' => 'Disco Duro SSD 500 GB - Marca Toshiba',
        ]);
    }
}
