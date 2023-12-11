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
        Schema::table('audios', function (Blueprint $table) {
            $table->unsignedBigInteger('fk_puntInteres')->nullable();
            $table->foreign('fk_puntInteres')
                ->references('id')
                ->on('puntsInteres')
                ->onDelete('CASCADE')
                ->onUpdate('SET NULL');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('audios', function (Blueprint $table) {
$table->dropForeign("audios_fk_puntInteres_foreign");
        });
    }
};
