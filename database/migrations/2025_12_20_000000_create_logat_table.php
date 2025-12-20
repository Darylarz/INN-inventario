<?php


use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('logcat', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->nullable()->constrained()->nullOnDelete();
            $table->string('accion'); // e.g. created, updated, deleted
            $table->string('tipo_sujeto')->nullable();
            $table->unsignedBigInteger('sujeto_id')->nullable();
            $table->text('descripcion')->nullable();
            $table->string('ip')->nullable();
            $table->string('user_agent')->nullable();
            $table->json('propiedades')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('logcat');
    }
};