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

            $table->unsignedBigInteger("fk_municipi")->nullable();
            $table->foreign("fk_municipi")
                ->references("id")
                ->on("municipis")
                ->onDelete("CASCADE")
                ->onUpdate("SET NULL");

            $table->unsignedBigInteger("fk_gestor")->nullable();
            $table->foreign("fk_gestor")
                ->references("id")
                ->on("users")
                ->onDelete("CASCADE")
                ->onUpdate("SET NULL");

            $table->unsignedBigInteger("fk_tipusEspai")->nullable();
            $table->foreign("fk_tipusEspai")
                ->references("id")
                ->on("tipusEspais")
                ->onDelete("CASCADE")
                ->onUpdate("SET NULL");

            $table->unsignedBigInteger("fk_imatge")->nullable();
            $table->foreign("fk_imatge")
                ->references("id")
                ->on("imatges")
                ->onDelete("SET NULL")
                ->onUpdate("SET NULL");

        });
    }

    /**rip
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('espais', function (Blueprint $table) {
            $table->dropForeign("espais_fk_municipi_foreign");
            $table->dropForeign("espais_fk_tipusEspai_foreign");
            $table->dropForeign("espais_fk_gestor_foreign");
            $table->dropForeign("espais_fk_imatge_foreign");
        });
    }
};
