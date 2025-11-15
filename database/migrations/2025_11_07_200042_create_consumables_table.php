<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('consumables', function (Blueprint $table) {
            $table->id();
            $table->string('categoria'); // toner o material impresora
            $table->string('marca')->nullable();
            $table->string('modelo')->nullable();
            $table->string('modelo_impresora')->nullable();
            $table->string('color')->nullable();
            $table->string('tipo_material')->nullable();
            $table->string('impresora_destino')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('consumables');
    }
};
