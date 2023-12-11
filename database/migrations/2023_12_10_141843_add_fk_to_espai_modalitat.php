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
        Schema::table('espai_modalitat', function (Blueprint $table) {
            $table->foreignId('fk_espai')->nullable()->constrained('espais')->onUpdate('SET NULL')->onDelete('CASCADE');
            $table->foreignId('fk_modalitat')->nullable()->constrained('modalitats')->onUpdate('SET NULL')->onDelete('CASCADE');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('espai_modalitat', function (Blueprint $table) {
            $table->dropForeign("espai_modalitat_fk_espai_foreign");
            $table->dropForeign("espai_modalitat_fk_modalitat_foreign");
        });
    }
};
