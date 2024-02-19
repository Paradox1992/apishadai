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
        Schema::create('cfgstocks', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('device')->unsigned();
            $table->bigInteger('cfg')->unsigned();
            $table->timestamps();

            $table->foreign('device')->references('id')->on('devices');
            $table->foreign('cfg')->references('id')->on('configs');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('cfgstocks');
    }
};