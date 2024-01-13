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
        Schema::create('espai_arquitecte', function (Blueprint $table) {
            $table->id();
            $table->foreignId("fk_espai")->constrained("espais")->onDelete("SET NULL")->onDelete("CASCADE");
            $table->foreignId("fk_arquitecte")->constrained("arquitectes")->onDelete("SET NULL")->onDelete("CASCADE");
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('espai_arquitecte');
    }
};
