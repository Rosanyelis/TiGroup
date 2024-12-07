<?php

namespace Database\Seeders;

use App\Models\Correlative;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class CorrelativeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Correlative::create(['type' => 'Contract', 'prefix' => 'C', 'correlative_initial' => '1001', 'correlative_last' => '1001']);
        Correlative::create(['type' => 'Contract Renewed', 'prefix' => 'CR', 'correlative_initial' => '1001', 'correlative_last' => '1001']);
        Correlative::create(['type' => 'Quotation', 'prefix' => 'Q', 'correlative_initial' => '1001', 'correlative_last' => '1001']);
        Correlative::create(['type' => 'Work Order', 'prefix' => 'OT', 'correlative_initial' => '1001', 'correlative_last' => '1001']);
        Correlative::create(['type' => 'Invoice', 'prefix' => 'F', 'correlative_initial' => '1001', 'correlative_last' => '1001']);
        Correlative::create(['type' => 'Sale', 'prefix' => 'V', 'correlative_initial' => '1001', 'correlative_last' => '1001']);
    }
}
