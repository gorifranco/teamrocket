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
        Schema::create('visites', function (Blueprint $table) {
            $table->id();
            $table->string("nom");
            $table->string("descripcio");
            $table->date("dataInici");
            $table->date("dataFi");
            $table->boolean("reqInscripcio");
            $table->double("preu")->default(0.0);
            $table->integer("places");
            //camp calculat: $table->integer("visitants");
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('visites');
    }
};
