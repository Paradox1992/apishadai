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
        Schema::create('modulos', function (Blueprint $table) {
            $table->integer('id', true);
            $table->string('descripcion', 200);
            $table->integer('estado');
            $table->timestamps();
            $table->foreign('estado')->references('id')->on('modulo_estados')->onUpdate('No Action')->onDelete('No Action');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('modulos');
    }
};