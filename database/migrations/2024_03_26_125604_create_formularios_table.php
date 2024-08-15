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
        Schema::create('formularios', function (Blueprint $table) {
            $table->integer('id', true);
            $table->integer('modulo');
            $table->string('descripcion', 100);
            $table->integer('estado');
            $table->timestamps();
            $table->foreign('modulo')->references('id')->on('modulos')->onUpdate('No Action')->onDelete('No Action');
            $table->foreign('estado')->references('id')->on('frm_estados')->onUpdate('No Action')->onDelete('No Action');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('formularios');
    }
};
