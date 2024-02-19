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
        Schema::create('rhoras', function (Blueprint $table) {
            $table->id()->autoIncrement();
            $table->bigInteger('usuario')->unsigned()->notNullable();
            $table->bigInteger('device')->unsigned()->notNullable();
            $table->dateTime('entrada')->notNullable()->default(null);
            $table->dateTime('salida')->notNullable()->default(null);
            $table->time('total')->notNullable()->default(0);
            $table->timestamps();
            $table->foreign('usuario')->references('id')->on('users');
            $table->foreign('device')->references('id')->on('devices');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('rhoras');
    }
};
