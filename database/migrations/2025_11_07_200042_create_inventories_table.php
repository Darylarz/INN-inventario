<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
    
        
        // ... en la migración *_create_inventories_table.php (o la que reemplaza a articles)
Schema::create('inventories', function (Blueprint $table) {
    $table->id();

    // Campo de Polimorfismo: Para distinguir qué tipo de inventario es
    $table->string('type')->comment('activo, herramienta, consumible_toner, consumible_material'); 

    // Campos Comunes / Activos (Componentes de PC)
    $table->string('brand')->nullable()->comment('Marca'); // Marca
    $table->string('model')->nullable()->comment('Modelo'); // Modelo
    $table->string('capacity')->nullable()->comment('Capacidad (ej: 500GB, 8GB)'); // Capacidad (texto numerico)
    $table->string('item_type')->nullable()->comment('Tipo de Activo/Herramienta (ej: Disco Duro, Cable, Impresora)'); // Tipo

    // Campos Específicos de Activo (Adicionales)
    $table->string('generation')->nullable()->comment('Generación (ej: DDR4)'); // Generacion
    $table->decimal('watt_capacity', 8, 2)->nullable()->comment('Capacidad de Watt (Regulador)'); // Capacidad de watt (numero)
    $table->string('serial_number')->unique()->nullable()->comment('Serial (Dato numérico)'); // Serial
    $table->string('national_asset_tag')->unique()->nullable()->comment('Bien Nacional (Númerico/Alfabético)'); // Bien nacional

    // Campos de Herramientas
    // (Utilizan 'name' y 'item_type' de los comunes si defines una tabla 'tools')

    // Campos de Consumibles (Toner y Materiales)
    $table->string('toner_color')->nullable()->comment('Color de toner'); // Color de toner
    $table->string('printer_model')->nullable()->comment('Modelo de impresora compatible'); // Modelo de impresora compatible
    $table->string('material_type')->nullable()->comment('Tipo de material de impresora'); // Tipo material
    
    // Campos Originales eliminados o renombrados:
    // $table->dropColumn(['sku', 'description', 'stock', 'price']); 
    // Los campos 'name', 'stock', 'price' ahora tendrán nombres más específicos.

    $table->timestamps();
});

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('inventories');
    }
};
