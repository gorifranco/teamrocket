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
        Schema::table('puntsInteres', function (Blueprint $table) {
            $table->unsignedBigInteger('fk_espai')->nullable();
            $table->foreign('fk_espai')
                ->references('id')
                ->on('espais')
                ->onDelete('CASCADE')
                ->onUpdate('SET NULL');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('puntsInteres', function (Blueprint $table) {
            $table->dropForeign("puntsInteres_fk_espai_foreign");
        });
    }
};
