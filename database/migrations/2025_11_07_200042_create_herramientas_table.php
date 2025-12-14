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
    
Schema::create('herramientas', function (Blueprint $table) {
    $table->id();
    $table->string('nombre_herramienta');
    $table->string('tipo_herramienta');  // manual, eléctrica, medición, etc.
    $table->integer('cantidad')->default(1);
    $table->string('bien_nacional')->nullable();
    $table->string('numero_serie')->nullable();
    $table->string('estado_herramienta')->nullable();
    $table->string('observaciones_herramienta')->nullable();
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



