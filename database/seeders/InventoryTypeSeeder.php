<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\TipoInventario;

class InventoryTypeSeeder extends Seeder
{
    public function run()
    {
        $types = ['PC', 'Consumible', 'Herramienta'];

        foreach ($types as $type) {
            TipoInventario::updateOrCreate(['nombre' => $type]);
        }
    }
}
