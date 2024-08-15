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
        Schema::create('permisos', function (Blueprint $table) {
            $table->integer('id')->autoIncrement();
            $table->bigInteger('usuario')->unsigned();
            $table->integer('modulo');
            $table->integer('formulario');
            $table->dateTime('last_access')->nullable();
            $table->timestamps();
            $table->foreign('usuario')->references('id')->on('users')->onDelete('No Action');
            $table->foreign('modulo')->references('id')->on('modulos')->onDelete('No Action');
            $table->foreign('formulario')->references('id')->on('formularios')->onDelete('No Action');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('permisos');
    }
};