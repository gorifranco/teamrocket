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
        Schema::table('comentaris', function (Blueprint $table) {
            $table->unsignedBigInteger('fk_usuari')->nullable();
            $table->foreign('fk_usuari')
                ->references('id')
                ->on('users')
                ->onDelete('CASCADE')
                ->onUpdate('SET NULL');

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
        Schema::table('comentaris', function (Blueprint $table) {
            $table->dropForeign("comentaris_fk_usuari_foreign");
            $table->dropForeign("comentaris_fk_espai_foreign");
        });
    }
};
