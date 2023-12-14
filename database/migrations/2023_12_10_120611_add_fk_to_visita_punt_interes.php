<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('visita_puntInteres', function (Blueprint $table) {
            $table->unsignedBigInteger('fk_puntInteres')->nullable();
            $table->foreign('fk_puntInteres')
                ->references('id')
                ->on('puntsInteres')
                ->onDelete('CASCADE')
                ->onUpdate('SET NULL');

            $table->unsignedBigInteger('fk_visita')->nullable();
            $table->foreign('fk_visita')
                ->references('id')
                ->on('visites')
                ->onDelete('CASCADE')
                ->onUpdate('SET NULL');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('visita_puntInteres', function (Blueprint $table) {
            $table->dropForeign("visita_puntInteres_fk_puntInteres_foreign");
            $table->dropForeign("visita_puntInteres_fk_visita_foreign");
        });
    }
};
