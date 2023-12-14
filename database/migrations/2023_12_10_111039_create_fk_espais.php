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
        Schema::table('espais', function (Blueprint $table) {
            $table->unsignedBigInteger('fk_arquitecte')->nullable();
            $table->foreign('fk_arquitecte')
                ->references('id')
                ->on('arquitectes')
                ->onDelete('CASCADE')
                ->onUpdate('SET NULL');

            $table->unsignedBigInteger("fk_municipi")->nullable();
            $table->foreign("fk_municipi")
                ->references("id")
                ->on("municipis")
                ->onDelete("CASCADE")
                ->onUpdate("SET NULL");

            $table->unsignedBigInteger("fk_tipusEspai")->nullable();
            $table->foreign("fk_tipusEspai")
                ->references("id")
                ->on("tipusEspais")
                ->onDelete("CASCADE")
                ->onUpdate("SET NULL");
        });
    }

    /**rip
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('espais', function (Blueprint $table) {
            $table->dropForeign("espais_fk_arquitecte_foreign");
            $table->dropForeign("espais_fk_municipi_foreign");
            $table->dropForeign("espais_fk_tipusEspai_foreign");
        });
    }
};
