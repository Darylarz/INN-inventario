<?php

use App\Models\Inventory;
use Illuminate\Database\Seeder;

class InventorySeeder extends Seeder
{
    public function run(): void
    {
        // 1. Ejemplo de Activo Fijo (Disco Duro)
        Inventory::create([
            'type' => 'activo',
            'brand' => 'Seagate',
            'model' => 'Barracuda 1TB',
            'capacity' => '1TB',
            'item_type' => 'Disco Duro HDD',
            'serial_number' => 'HDD7890123',
            'national_asset_tag' => 'BN-IT-001',
        ]);
        
        // 2. Ejemplo de Herramienta
        Inventory::create([
            'type' => 'herramienta',
            'brand' => 'Fluke',
            'model' => 'ProTool-101',
            'item_type' => 'Crimpadora de Red', // Nombre de la herramienta
            'serial_number' => 'TOOL4567',
        ]);

        // 3. Ejemplo de Consumible (Toner)
        Inventory::create([
            'type' => 'consumible_toner',
            'brand' => 'HP',
            'model' => 'CF280A',
            'printer_model' => 'LaserJet Pro 400',
            'toner_color' => 'Negro',
            'serial_number' => 'TN9876',
        ]);
        
        // 4. Ejemplo de Consumible (Material de Impresora)
        Inventory::create([
            'type' => 'consumible_material',
            'item_type' => 'Papel Carta 80gr', // Tipo de material
            'material_type' => 'Papel', 
        ]);

        // Puedes usar Factories para crear más datos de prueba si lo deseas.
    }
}
