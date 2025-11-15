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
    
Schema::create('toners', function (Blueprint $table) {
    $table->id();
    $table->string('marca');
    $table->string('modelo');
    $table->string('modelo_impresora');
    $table->string('color');
    $table->integer('cantidad')->default(0);
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



