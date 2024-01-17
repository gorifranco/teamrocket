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
            $table->foreignId("fk_espai")->constrained("espais")->onDelete("CASCADE")->onDelete("CASCADE");
            $table->foreignId("fk_arquitecte")->constrained("arquitectes")->onDelete("CASCADE")->onDelete("CASCADE");
            $table->primary(['fk_espai', 'fk_arquitecte']);
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
