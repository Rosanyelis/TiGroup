<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        $this->call([
            RolsSeeder::class,
            UserSeeder::class,
            TypeProductSeeder::class,
            CategorySeeder::class,
            ProductSeeder::class,
        ]);

    }
}
