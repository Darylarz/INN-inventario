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
Schema::create('inventario', function (Blueprint $table) {
    $table->id();

    // Campo de Polimorfismo: Para distinguir qué tipo de inventario es
    $table->string('tipo')->nullable()->comment('activo, herramienta, consumible_toner, consumible_material'); 

    // Campos Comunes / Activos (Componentes de PC)
    $table->string('marca')->nullable()->comment('Marca'); // Marca
    $table->string('modelo')->nullable()->comment('Modelo'); // Modelo
    $table->string('capacidad')->nullable()->comment('Capacidad (ej: 500GB, 8GB)'); // Capacidad (texto numerico)
    $table->string('tipo_item')->nullable()->comment('Tipo de Activo/Herramienta (ej: Disco Duro, Cable, Impresora)'); // Tipo

    // Campos Específicos de Activo (Adicionales)
    $table->string('generacion')->nullable()->comment('Generación (ej: DDR4)'); // Generacion
    $table->decimal('capacidad_watt', 8, 2)->nullable()->comment('Capacidad de Watt (Regulador)'); // Capacidad de watt (numero)
    $table->string('numero_serial')->unique()->nullable()->comment('Serial (Dato numérico)'); // Serial
    $table->string('bien_nacional')->unique()->nullable()->comment('Bien Nacional (Númerico/Alfabético)'); // Bien nacional

    // Campos de Herramientas
    // (Utilizan 'name' y 'item_type' de los comunes si defines una tabla 'tools')

    // Campos de Consumibles (Toner y Materiales)
    $table->string('toner_color')->nullable()->comment('Color de toner'); // Color de toner
    $table->string('modelo_impresora')->nullable()->comment('Modelo de impresora compatible'); // Modelo de impresora compatible
    $table->string('tipo_material')->nullable()->comment('Tipo de material de impresora'); // Tipo material
    
    $table->string('nombre')->nullable();
$table->boolean('reciclado')->default(false)->nullable();
$table->string('ingresado_por')->nullable();
$table->date('fecha_ingreso')->nullable();
$table->boolean('esta_desactivado')->default(false)->after('tipo_material');
            $table->timestamp('fecha_desactivado')->nullable()->after('esta_desactivado');
            $table->string('razon_desactivado', 500)->nullable()->after('fecha_desactivado');
             if (!Schema::hasColumn('inventario', 'cantidad')) {
                $table->unsignedInteger('cantidad')->default(0)->after('tipo_material');
            }
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
        Schema::dropIfExists('inventario');
    }
};



