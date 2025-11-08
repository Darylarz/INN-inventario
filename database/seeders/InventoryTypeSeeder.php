<?php

use Illuminate\Database\Seeder;
use App\Models\InventoryType;

class InventoryTypeSeeder extends Seeder
{
    public function run(): void
    {
        InventoryType::firstOrCreate(['slug' => 'activo'], ['name' => 'Activo Fijo']);
        InventoryType::firstOrCreate(['slug' => 'herramienta'], ['name' => 'Herramienta']);
        InventoryType::firstOrCreate(['slug' => 'consumible'], ['name' => 'Consumible']);
        // Podrías añadir más si lo necesitas
    }
}