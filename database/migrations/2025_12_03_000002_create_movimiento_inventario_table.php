<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
         Schema::create('movimiento_inventario', function (Blueprint $table) {
            $table->id();

            // columnas (creamos las columnas primero, añadimos constraints después)
            $table->unsignedBigInteger('inventario_id');
            $table->enum('tipo', ['entrada', 'salida']);
            $table->unsignedInteger('cantidad');
            $table->unsignedBigInteger('user_id');
            $table->string('nota')->nullable();
            $table->timestamps();
            $table->unsignedBigInteger('ubicacion_id')->nullable();

            // índice corregido (nombres de columnas en la tabla actual)
            $table->index(['inventario_id', 'tipo']);
        });

        // Añadir constraints solo si las tablas referenciadas existen (evita errores de orden)
        if (Schema::hasTable('inventario')) {
            Schema::table('movimiento_inventario', function (Blueprint $table) {
                $table->foreign('inventario_id')->references('id')->on('inventario')->cascadeOnDelete();
            });
        }

        if (Schema::hasTable('users')) {
            Schema::table('movimiento_inventario', function (Blueprint $table) {
                $table->foreign('user_id')->references('id')->on('users')->cascadeOnDelete();
            });
        }

        if (Schema::hasTable('ubicaciones')) {
            Schema::table('movimiento_inventario', function (Blueprint $table) {
                $table->foreign('location_id')->references('id')->on('ubicaciones')->nullOnDelete();
            });
        }
    }

    public function down(): void
    {
        Schema::dropIfExists('moviento_inventario');
    }
};
