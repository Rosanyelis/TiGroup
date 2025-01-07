<?php

namespace Database\Seeders;

use App\Models\Board;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class BoardSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Board::create(['workspace_id' =>'1', 'title' => 'Leads', 'title_slug' => 'leads', 'status' => 'Activo']);
        Board::create(['workspace_id' =>'1', 'title' => 'Cotizados', 'title_slug' => 'cotizados', 'status' => 'Activo']);
        Board::create(['workspace_id' =>'1', 'title' => '80% Cerrados', 'title_slug' => '80-cerrados', 'status' => 'Activo']);
        Board::create(['workspace_id' =>'1', 'title' => 'Cerrados', 'title_slug' => 'cerrados', 'status' => 'Activo']);
        Board::create(['workspace_id' =>'1', 'title' => 'Perdidos', 'title_slug' => 'perdidos', 'status' => 'Activo']);
    }
}
