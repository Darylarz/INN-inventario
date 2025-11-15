<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\InventoryType;

class InventoryTypesSeeder extends Seeder
{
    public function run()
    {
        $types = ['PC', 'Consumable', 'Tool'];

        foreach ($types as $type) {
            InventoryType::updateOrCreate(['name' => $type]);
        }
    }
}
