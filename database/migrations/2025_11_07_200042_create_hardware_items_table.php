<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('hardware_items', function (Blueprint $table) {
    $table->id();
    $table->string('marca');
    $table->string('modelo');
    $table->string('capacidad')->nullable();
    $table->string('tipo');
    $table->string('generacion')->nullable();
    $table->integer('capacidad_watt')->nullable();
    $table->string('numero_serie');
    $table->string('bien_nacional');
    $table->timestamps();
});

    }

    public function down(): void
    {
        Schema::dropIfExists('hardware_items');
    }
};
