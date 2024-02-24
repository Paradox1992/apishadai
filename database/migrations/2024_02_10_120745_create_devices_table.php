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
        Schema::create('devices', function (Blueprint $table) {
            $table->id()->unique()->autoIncrement();
            $table->string('ip', 16);
            $table->string('name', 80);
            $table->unsignedBigInteger('stock');
            $table->foreign('stock')->references('id')->on('stocks')->onDelete('cascade')->onUpdate('cascade');
            $table->unsignedBigInteger('sts');
            $table->foreign('sts')->references('id')->on('devicestatus')->onDelete('cascade')->onUpdate('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('devices');
    }
};