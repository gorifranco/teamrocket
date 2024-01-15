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
        Schema::create('espais', function (Blueprint $table) {
            $table->id();
            $table->string("nom")->unique();
            $table->string("descripcio",1000);
            $table->string("direccio");
            $table->integer("any_construccio");
            $table->enum("grau_accessibilitat", ["baix", "mitj", "alt"]);
            $table->string("web")->nullable();
            $table->string("email")->nullable();
            $table->string("telefon");
            $table->boolean("destacada")->default(false);
            $table->boolean("activat")->default(false);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('espais');
    }
};
