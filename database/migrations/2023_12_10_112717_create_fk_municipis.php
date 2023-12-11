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
        Schema::table('municipis', function (Blueprint $table) {
            $table->unsignedBigInteger("fk_illa")->nullable();
            $table->foreign("fk_illa")
                ->references("id")
                ->on("illes")
                ->onDelete("CASCADE")
                ->onUpdate("SET NULL");

            $table->unsignedBigInteger("fk_zona")->nullable();
            $table->foreign("fk_zona")
                ->references("id")
                ->on("zones")
                ->onDelete("CASCADE")
                ->onUpdate("SET NULL");
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('municipis', function (Blueprint $table) {
            $table->dropForeign("municipis_fk_illa_foreign");
            $table->dropForeign("municipis_fk_zona_foreign");
        });
    }
};
