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
        Schema::create('inventario', function (Blueprint $table) {
            $table->id();

            // Campo de Polimorfismo
            $table->string('tipo')->nullable()->comment('activo, herramienta, consumible_toner, consumible_material'); 

            // Campos Comunes / Activos (Componentes de PC)
            $table->string('marca')->nullable()->comment('Marca');
            $table->string('modelo')->nullable()->comment('Modelo');
            $table->string('capacidad')->nullable()->comment('Capacidad (ej: 500GB, 8GB)');
            $table->string('tipo_item')->nullable()->comment('Tipo de Activo/Herramienta (ej: Disco Duro, Cable, Impresora)');

            // Campos Específicos de Activo
            $table->string('generacion')->nullable()->comment('Generación (ej: DDR4)');
            $table->decimal('capacidad_watt', 8, 2)->nullable()->comment('Capacidad de Watt (Regulador)');
            $table->string('numero_serial')->unique()->nullable()->comment('Serial (Dato numérico)');
            $table->string('bien_nacional')->unique()->nullable()->comment('Bien Nacional (Númerico/Alfabético)');

            // Campos de Consumibles (Toner y Materiales)
            $table->string('toner_color')->nullable()->comment('Color de toner');
            $table->string('modelo_impresora')->nullable()->comment('Modelo de impresora compatible');
            $table->string('tipo_material')->nullable()->comment('Tipo de material de impresora');
            
            // --- Columnas insertadas en el orden que deseabas (sin el método ->after) ---
            $table->unsignedInteger('cantidad')->default(0);
            $table->boolean('esta_desactivado')->default(false);
            $table->timestamp('fecha_desactivado')->nullable();
            $table->string('razon_desactivado', 500)->nullable();
            // --------------------------------------------------------------------------

            $table->string('nombre')->nullable();
            $table->boolean('reciclado')->default(false)->nullable();
            $table->string('ingresado_por')->nullable();
            $table->date('fecha_ingreso')->nullable();

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