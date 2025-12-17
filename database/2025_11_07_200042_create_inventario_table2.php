<?php
<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('inventario', function (Blueprint $table) {
            $table->id();

            // Polimorfismo / tipo
            $table->string('tipo')->nullable()->comment('activo, herramienta, consumible_toner, consumible_material');

            // Campos comunes
            $table->string('marca')->nullable()->comment('Marca');
            $table->string('modelo')->nullable()->comment('Modelo');
            $table->string('capacidad')->nullable()->comment('Capacidad (ej: 500GB, 8GB)');
            $table->string('tipo_item')->nullable()->comment('Tipo de Activo/Herramienta (ej: Disco Duro, Cable, Impresora)');

            // Campos adicionales
            $table->string('generacion')->nullable()->comment('Generación (ej: DDR4)');
            $table->decimal('capacidad_watt', 8, 2)->nullable()->comment('Capacidad de Watt (Regulador)');
            $table->string('numero_serial')->unique()->nullable()->comment('Serial (Dato numérico)');
            $table->string('bien_nacional')->unique()->nullable()->comment('Bien Nacional (Númerico/Alfabético)');

            // Consumibles / impresora
            $table->string('toner_color')->nullable()->comment('Color de toner');
            $table->string('modelo_impresora')->nullable()->comment('Modelo de impresora compatible');
            $table->string('tipo_material')->nullable()->comment('Tipo de material de impresora');

            // Otros
            $table->string('nombre')->nullable();
            $table->boolean('reciclado')->default(false);
            $table->string('ingresado_por')->nullable();
            $table->date('fecha_ingreso')->nullable();

            // Estado / desactivación
            $table->boolean('esta_desactivado')->default(false);
            $table->timestamp('fecha_desactivado')->nullable();
            $table->string('razon_desactivado', 500)->nullable();

            // Cantidad
            $table->unsignedInteger('cantidad')->default(0);

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('inventario');
    }
};