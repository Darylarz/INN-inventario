<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration {
    public function up(): void
    {
        // Tool
        DB::table('inventories')
            ->whereIn('item_type', [
                'Herramienta','herramienta','Herramientas','herramientas',
                'tool','tools','Tools'
            ])
            ->update(['item_type' => 'Tool']);

        // Consumable
        DB::table('inventories')
            ->whereIn('item_type', [
                'Consumible','consumible','Consumibles','consumibles',
                'consumable','consumables','Consumables'
            ])
            ->update(['item_type' => 'Consumable']);
    }

    public function down(): void
    {
        // Reversión aproximada a español
        DB::table('inventories')->where('item_type', 'Tool')->update(['item_type' => 'Herramienta']);
        DB::table('inventories')->where('item_type', 'Consumable')->update(['item_type' => 'Consumible']);
    }
};