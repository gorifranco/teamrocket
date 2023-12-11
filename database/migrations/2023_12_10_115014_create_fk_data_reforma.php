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
        Schema::table('dataReforma', function (Blueprint $table) {
            $table->unsignedBigInteger("fk_espaiId")->nullable();
            $table->foreign("fk_espaiId")
                ->references("id")
                ->on("espais")
                ->onDelete("CASCADE")
                ->onUpdate("SET NULL");
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('dataReforma', function (Blueprint $table) {
            $table->dropForeign("dataReforma_fk_espaiId_foreign");
        });
    }
};
