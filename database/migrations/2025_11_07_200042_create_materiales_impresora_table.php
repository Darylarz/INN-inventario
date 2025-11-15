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
    
Schema::create('materiales_impresora', function (Blueprint $table) {
    $table->id();
    $table->string('tipo_material'); // fusor, rodillo, cintas etc.
    $table->string('impresora'); // modelo o referencia
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



