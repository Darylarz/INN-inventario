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
        Schema::table('inventories', function (Blueprint $table) {
            $table->boolean('is_disabled')->default(false)->after('material_type');
            $table->timestamp('disabled_at')->nullable()->after('is_disabled');
            $table->string('disabled_reason', 500)->nullable()->after('disabled_at');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('inventories', function (Blueprint $table) {
            $table->dropColumn(['is_disabled', 'disabled_at', 'disabled_reason']);
        });
    }
};
