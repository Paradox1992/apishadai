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
        Schema::create('matchtokens', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('usuario')->unsigned();
            $table->integer('pc');
            $table->longText('token');
            $table->timestamps();
            $table->foreign('pc')->references('id')->on('pcs')->onDelete('NO ACTION');
            $table->foreign('usuario')->references('id')->on('users')->onDelete('NO ACTION');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('matchtokens');
    }
};
