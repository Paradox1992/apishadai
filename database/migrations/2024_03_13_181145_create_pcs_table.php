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
        Schema::create('pcs', function (Blueprint $table) {
            $table->integer('id', true);
            $table->string('ip', 18);
            $table->string('name', 100);
            $table->integer('stock');
            $table->integer('estado')->notNull();
            $table->timestamps();
            $table->foreign('estado')->references('id')->on('pcs_estados')->onUpdate('no action')->onDelete('no action');
            $table->foreign('stock')->references('id')->on('stocks')->onUpdate('no action')->onDelete('no action');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pcs');
    }
};